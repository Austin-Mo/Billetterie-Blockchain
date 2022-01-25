// Source code to interact with smart contract

// web3 provider with fallback for old version
if (window.ethereum) {
	window.web3 = new Web3(window.ethereum)
	try {
      // ask user for permission
      ethereum.enable()
      // user approved permission
  } catch (error) {
      // user rejected permission
      console.log('user rejected permission')
  }
}
else if (window.web3) {
	window.web3 = new Web3("http://localhost:3300")
  // no need to ask for permission
}
else {
	window.alert('Non-Ethereum browser detected. You should consider trying MetaMask!')
}

console.log (window.web3.currentProvider)

// contractAddress and abi of the Billeterie_Smart_Contract are setted after contract deploy
var contractBilleterieAddress = '0x7A350f1BB91812d8dC21D5674Bb47b133C64d2b8';
var abiBilleterie = JSON.parse( `[
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "taille",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "address",
				"name": "address_billet",
				"type": "address"
			}
		],
		"name": "NewAddress",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "address_billet",
				"type": "address"
			}
		],
		"name": "addAddress",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "getAddresses",
		"outputs": [
			{
				"internalType": "address[]",
				"name": "",
				"type": "address[]"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "address_billet",
				"type": "address"
			}
		],
		"name": "removeAddress",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	}
]` );

//contract instance
billeterieSmartContract = new web3.eth.Contract(abiBilleterie, contractBilleterieAddress);

var abiMatch = JSON.parse(`[
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "_homeTeam",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "_guestTeam",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "_matchDate",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "_numberOfTickets",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "_ticketPrice",
				"type": "uint256"
			}
		],
		"stateMutability": "nonpayable",
		"type": "constructor"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_user",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "_amount",
				"type": "uint256"
			}
		],
		"name": "buyTicket",
		"outputs": [],
		"stateMutability": "payable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "getMatch",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"name": "ticketHolders",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_user",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "_amount",
				"type": "uint256"
			}
		],
		"name": "useTickets",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "withdraw",
		"outputs": [],
		"stateMutability": "payable",
		"type": "function"
	}
]`);

// Accounts
var account;
web3.eth.getAccounts(function(err, accounts) {
	if (err != null) {
		alert("Error retrieving accounts.");
		return;
	}
	if (accounts.length == 0) {
		alert("No account found! Make sure the Ethereum client is configured properly.");
		return;
	}
	account = accounts[0];
	console.log('Account: ' + account);
	web3.eth.defaultAccount = account;
});


//Smart contractBilletterie functions
function getMatchs() {
	htmlString =''; 
	billeterieSmartContract.methods.getAddresses().call().then( function( addresses ) {
		console.log('addresses ==>', addresses);
	  	for (let i = 0; i < addresses.length; i++) {
	    // contractAddressMatch and abiMatch are setted after contract deploy
			var contractAddressMatch = addresses[i];
			//contract instance
			contractMatch = new web3.eth.Contract(abiMatch, contractAddressMatch);

			contractMatch.methods.getMatch().call().then( function( infos ) {
				if(i%3 == 0){
					htmlString += '<div class="row gy-4">';
				}
				htmlString += '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">'+
				'<div class="icon-box">'+
					              '<h4><a>'+infos[0]+' vs '+infos[1]+'</a></h4>'+
					              '<p>Date : '+infos[2]+'</p>'+
					              '<hr>'+
					              '<p>Places totales : '+infos[3]+'</p>'+
					              '<hr>'+
					              '<p>Prix : '+infos[4]/1000000000000000000+' ETH</p>'+
					              '<hr>'+
					              '<p><input type="number" id="numberOfTicket'+i+'" value="1" name="numberOfTicket" min="1" max="'+infos[3]+'"></p>'+
					              '<hr>'+
					              '<button class="btn btn-primary" type="submit" value="'+i+'" name="idProjet" onclick="buyTicket('+i+')">'+
					              'Acheter'+
					              '</button>'+
					            '</div>'+
					          '</div>';
				if(i%3 == 2 || i == addresses.length-1){
					htmlString += '</div>';
				}
			});
		}
		setTimeout(function(){ 
	  		document.getElementById('allMatchs').innerHTML = htmlString; 
	  	},1000);
	  	
	});   
}


function getMatchsAdmin() {
	htmlString =''; 
	billeterieSmartContract.methods.getAddresses().call().then( function( addresses ) {
		console.log('addresses ==>', addresses);
	  	for (let i = 0; i < addresses.length; i++) {
	    // contractAddressMatch and abiMatch are setted after contract deploy
			var contractAddressMatch = addresses[i];
			//contract instance
			contractMatch = new web3.eth.Contract(abiMatch, contractAddressMatch);

			contractMatch.methods.getMatch().call().then( function( infos ) {
				if(i%3 == 0){
					htmlString += '<div class="row gy-4">';
				}
				htmlString += '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">'+
				'<div class="icon-box">'+
					              '<h4><a>'+infos[0]+' vs '+infos[1]+'</a></h4>'+
					              '<p>Date : '+infos[2]+'</p>'+
					              '<hr>'+
					              '<p>Places restantes : '+infos[3]+'</p>'+
					              '<hr>'+
					              '<p>Prix : '+infos[4]/1000000000000000000+' ETH</p>'+
					              '<hr>'+
					              '<button class="btn btn-primary" type="submit" value="'+i+'" name="idProjet" onclick="withdraw('+i+')">'+
					              'Récupérer l\'argent'+
					              '</button>'+
					            '</div>'+
					          '</div>';
				if(i%3 == 2 || i == addresses.length-1){
					htmlString += '</div>';
				}
			});
		}
		setTimeout(function(){ 
	  		document.getElementById('allMatchs').innerHTML = htmlString;
	  	},1000);
	  	
	});   
}



//Smart contractMatch functions
function buyTicket(id) {
	const numberOfTicket = document.getElementById("numberOfTicket"+id).value;
	billeterieSmartContract.methods.getAddresses().call().then( function( addresses ) {
	    // contractAddressMatch and abiMatch are setted after contract deploy
		var contractAddressMatch = addresses[id];
		//contract instance
		contractMatch = new web3.eth.Contract(abiMatch, contractAddressMatch);
		console.log(contractMatch.methods.getMatch().call());

		contractMatch.methods.getMatch().call().then(function(infos){
			const value = numberOfTicket*infos[4];
	  		console.log('value ==>',value); 
	  		contractMatch.methods.buyTicket(account,numberOfTicket).send( {from: account, value : value});
		});
	});   
}




function withdraw(id) {
	billeterieSmartContract.methods.getAddresses().call().then( function( addresses ) {
	    // contractAddressMatch and abiMatch are setted after contract deploy
		var contractAddressMatch = addresses[id];

		console.log("address ==>",addresses[id]);

		//contract instance
		contractMatch = new web3.eth.Contract(abiMatch, contractAddressMatch);
		contractMatch.methods.withdraw().send({from:account});

		console.log("address ==>",contractMatch);

		
		billeterieSmartContract.methods.removeAddress(addresses[id]).send({from:account});
	});   
}



function createMatch() {
	homeTeam = document.getElementById("domicile").value; 
    guestTeam = document.getElementById("exterieur").value;
    matchDate = document.getElementById("date").value;
    ticketPrice = web3.utils.toWei(document.getElementById("price").value,'ether');
    numberOfTickets = document.getElementById("numberOfPlace").value;
    owner = account;

	// Match ABI
    let match_contract = new web3.eth.Contract(abiMatch);

    let data = {
    	data: '0x60806040523480156200001157600080fd5b5060405162000f1738038062000f17833981810160405281019062000037919062000221565b84600090805190602001906200004f929190620000dc565b50836001908051906020019062000068929190620000dc565b50826002908051906020019062000081929190620000dc565b50816004819055508060038190555033600560006101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff1602179055505050505050620004ae565b828054620000ea90620003a5565b90600052602060002090601f0160209004810192826200010e57600085556200015a565b82601f106200012957805160ff19168380011785556200015a565b828001600101855582156200015a579182015b82811115620001595782518255916020019190600101906200013c565b5b5090506200016991906200016d565b5090565b5b80821115620001885760008160009055506001016200016e565b5090565b6000620001a36200019d846200032f565b62000306565b905082815260208101848484011115620001c257620001c162000474565b5b620001cf8482856200036f565b509392505050565b600082601f830112620001ef57620001ee6200046f565b5b8151620002018482602086016200018c565b91505092915050565b6000815190506200021b8162000494565b92915050565b600080600080600060a0868803121562000240576200023f6200047e565b5b600086015167ffffffffffffffff81111562000261576200026062000479565b5b6200026f88828901620001d7565b955050602086015167ffffffffffffffff81111562000293576200029262000479565b5b620002a188828901620001d7565b945050604086015167ffffffffffffffff811115620002c557620002c462000479565b5b620002d388828901620001d7565b9350506060620002e6888289016200020a565b9250506080620002f9888289016200020a565b9150509295509295909350565b60006200031262000325565b9050620003208282620003db565b919050565b6000604051905090565b600067ffffffffffffffff8211156200034d576200034c62000440565b5b620003588262000483565b9050602081019050919050565b6000819050919050565b60005b838110156200038f57808201518184015260208101905062000372565b838111156200039f576000848401525b50505050565b60006002820490506001821680620003be57607f821691505b60208210811415620003d557620003d462000411565b5b50919050565b620003e68262000483565b810181811067ffffffffffffffff8211171562000408576200040762000440565b5b80604052505050565b7f4e487b7100000000000000000000000000000000000000000000000000000000600052602260045260246000fd5b7f4e487b7100000000000000000000000000000000000000000000000000000000600052604160045260246000fd5b600080fd5b600080fd5b600080fd5b600080fd5b6000601f19601f8301169050919050565b6200049f8162000365565b8114620004ab57600080fd5b50565b610a5980620004be6000396000f3fe60806040526004361061004a5760003560e01c80633ccfd60b1461004f5780633d8a03af1461005957806366a5ef2f14610088578063734d13b8146100a45780637e33b76c146100e1575b600080fd5b61005761010a565b005b34801561006557600080fd5b5061006e6101d5565b60405161007f9594939291906106cb565b60405180910390f35b6100a2600480360381019061009d91906105fd565b61039e565b005b3480156100b057600080fd5b506100cb60048036038101906100c691906105d0565b6103da565b6040516100d89190610773565b60405180910390f35b3480156100ed57600080fd5b50610108600480360381019061010391906105fd565b6103f2565b005b600560009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff161461019a576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040161019190610753565b60405180910390fd5b600560009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16ff5b60608060606000806000600160026004546003548480546101f5906108fd565b80601f0160208091040260200160405190810160405280929190818152602001828054610221906108fd565b801561026e5780601f106102435761010080835404028352916020019161026e565b820191906000526020600020905b81548152906001019060200180831161025157829003601f168201915b50505050509450838054610281906108fd565b80601f01602080910402602001604051908101604052809291908181526020018280546102ad906108fd565b80156102fa5780601f106102cf576101008083540402835291602001916102fa565b820191906000526020600020905b8154815290600101906020018083116102dd57829003601f168201915b5050505050935082805461030d906108fd565b80601f0160208091040260200160405190810160405280929190818152602001828054610339906108fd565b80156103865780601f1061035b57610100808354040283529160200191610386565b820191906000526020600020905b81548152906001019060200180831161036957829003601f168201915b50505050509250945094509450945094509091929394565b34600354826103ad9190610800565b11156103b857600080fd5b6103c28282610400565b806004546103d0919061085a565b6004819055505050565b60066020528060005260406000206000915090505481565b6103fc8282610492565b5050565b80600660008473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020019081526020016000205461044b91906107aa565b600660008473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001908152602001600020819055505050565b80600660008473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001908152602001600020541015610514576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040161050b90610733565b60405180910390fd5b80600660008473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020019081526020016000205461055f919061085a565b600660008473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001908152602001600020819055505050565b6000813590506105b5816109f5565b92915050565b6000813590506105ca81610a0c565b92915050565b6000602082840312156105e6576105e561098d565b5b60006105f4848285016105a6565b91505092915050565b600080604083850312156106145761061361098d565b5b6000610622858286016105a6565b9250506020610633858286016105bb565b9150509250929050565b60006106488261078e565b6106528185610799565b93506106628185602086016108ca565b61066b81610992565b840191505092915050565b6000610683601f83610799565b915061068e826109a3565b602082019050919050565b60006106a6601683610799565b91506106b1826109cc565b602082019050919050565b6106c5816108c0565b82525050565b600060a08201905081810360008301526106e5818861063d565b905081810360208301526106f9818761063d565b9050818103604083015261070d818661063d565b905061071c60608301856106bc565b61072960808301846106bc565b9695505050505050565b6000602082019050818103600083015261074c81610676565b9050919050565b6000602082019050818103600083015261076c81610699565b9050919050565b600060208201905061078860008301846106bc565b92915050565b600081519050919050565b600082825260208201905092915050565b60006107b5826108c0565b91506107c0836108c0565b9250827fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff038211156107f5576107f461092f565b5b828201905092915050565b600061080b826108c0565b9150610816836108c0565b9250817fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff048311821515161561084f5761084e61092f565b5b828202905092915050565b6000610865826108c0565b9150610870836108c0565b9250828210156108835761088261092f565b5b828203905092915050565b6000610899826108a0565b9050919050565b600073ffffffffffffffffffffffffffffffffffffffff82169050919050565b6000819050919050565b60005b838110156108e85780820151818401526020810190506108cd565b838111156108f7576000848401525b50505050565b6000600282049050600182168061091557607f821691505b602082108114156109295761092861095e565b5b50919050565b7f4e487b7100000000000000000000000000000000000000000000000000000000600052601160045260246000fd5b7f4e487b7100000000000000000000000000000000000000000000000000000000600052602260045260246000fd5b600080fd5b6000601f19601f8301169050919050565b7f596f7520646f206e6f74206861766520616e6f756768207469636b6574732e00600082015250565b7f596f7520617265206e6f7420746865206f776e65722e00000000000000000000600082015250565b6109fe8161088e565b8114610a0957600080fd5b50565b610a15816108c0565b8114610a2057600080fd5b5056fea264697066735822122099278712455ab4352ee7fcc1c95f97330c1fd1b2ff8e7a01fad4aa5736b9c9de64736f6c63430008070033',
    	arguments: [
				    	homeTeam, 
				    	guestTeam, 
				    	matchDate, 
				    	numberOfTickets, 
				    	ticketPrice
				   	]
	}

	let parameter = {
	    from: account,
	    gas: web3.utils.toHex(800000),
	    gasPrice: web3.utils.toHex(web3.utils.toWei('30', 'gwei'))
	}

	match_contract.deploy(data).send(parameter, (err, transactionHash) => {
	    console.log('Transaction Hash :', transactionHash);
	}).on('confirmation', () => {}).then((newContractInstance) => {
		const matchAddress = newContractInstance.options.address;
	    console.log('Deployed Contract Address : ', matchAddress);
	    setTimeout(function(){ 
	  		billeterieSmartContract.methods.addAddress(matchAddress).send({from: account});
	  	},1000);
	  	console.log(billeterieSmartContract.methods);
	})
}


// Function that redirect the administrator
function redirectAdmin(){
	if(account==0x5eDc9603a4549545BB9c1dDeACf92b7D6Dfcb47E){
		window.location.href = "/indexAdmin.html";
	}
}

function redirectUser(){
	if(account!=0x5eDc9603a4549545BB9c1dDeACf92b7D6Dfcb47E){
		window.location.href = "/index.html";
	}
}



// signal
/*
billeterieSmartContract.events.EventMemo({
	fromBlock: 0
}, function(error, event){ console.log(event); })
.on("connected", function(subscriptionId){
	console.log("subscription",subscriptionId);
})
.on('data', function(event){
    console.log("get data event",event); // same results as the optional callback above
    getAddresses();
})
.on('changed', function(event){
    // remove event from local database
    console.log("changed",error, receipt);
})
.on('error', function(error, receipt) { // If the transaction was rejected by the network with a receipt, the second parameter will be the receipt.
	console.log(error, receipt);
});
*/




