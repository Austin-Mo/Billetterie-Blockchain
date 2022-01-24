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
var contractBilleterieAddress = '0x5F88e7198222dD4F793aE8C4950e1958C0e0EF1c';
var abiBilleterie = JSON.parse( `[
{ 
	"anonymous": false, 
	"inputs": 
	[ 
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
	"outputs": 	[ 
	{ 
		"internalType": "address[]", 
		"name": "", 
		"type": "address[]" 
	} 
	], 
	"stateMutability": "view", 
	"type": "function" 
}
]` );

//contract instance
billeterieSmartContract = new web3.eth.Contract(abiBilleterie, contractBilleterieAddress);

var abiMatch = JSON.parse( `[ { "inputs": [ { "internalType": "string", "name": "_homeTeam", "type": "string" }, { "internalType": "string", "name": "_guestTeam", "type": "string" }, { "internalType": "string", "name": "_matchDate", "type": "string" }, { "internalType": "uint256", "name": "_numberOfTickets", "type": "uint256" }, { "internalType": "uint256", "name": "_ticketPrice", "type": "uint256" } ], "stateMutability": "nonpayable", "type": "constructor" }, { "inputs": [ { "internalType": "address", "name": "_user", "type": "address" }, { "internalType": "uint256", "name": "_amount", "type": "uint256" } ], "name": "buyTicket", "outputs": [], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "getMatch", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "string", "name": "", "type": "string" }, { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "", "type": "address" } ], "name": "ticketHolders", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_user", "type": "address" }, { "internalType": "uint256", "name": "_amount", "type": "uint256" } ], "name": "useTickets", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [], "name": "withdraw", "outputs": [], "stateMutability": "nonpayable", "type": "function" } ]` );

var abiMatch = JSON.parse(`[ 
	{ 
		"constant": false, 
		"inputs": [ 
			{ 
				"name": "from", 
				"type": "address" 
			}, 
			{ 
				"name": "tokens", 
				"type": "uint256" 
			}, 
			{ 
				"name": "token", 
				"type": "address" 
			}, 
			{ 
				"name": "data", 
				"type": "bytes" 
			} ], 
		"name": "receiveApproval", "outputs": [], "payable": false, "stateMutability": "nonpayable", "type": "function" } ]`);
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
				console.log('methods ==>', contractMatch.methods);

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
					              '<p>Places restantes : '+infos[4]+'</p>'+
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
	  	},2000);
	  	
	});   
}

//Smart contractMatch functions
function buyTicket(id) {
	billeterieSmartContract.methods.getAddresses().call().then( function( addresses ) {
	    // contractAddressMatch and abiMatch are setted after contract deploy
		var contractAddressMatch = addresses[id];
		console.log(addresses[id]);
		//contract instance
		contractMatch = new web3.eth.Contract(abiMatch, contractAddressMatch);
		contractMatch.methods.buyTicket(account,1).send( {from: account});
	});   
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




