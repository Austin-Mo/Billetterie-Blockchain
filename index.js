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
  window.web3 = new Web3(window.web3.currentProvider)
  // no need to ask for permission
}
else {
  window.alert('Non-Ethereum browser detected. You should consider trying MetaMask!')
}

console.log (window.web3.currentProvider)

// contractAddress and abi of the Billeterie_Smart_Contract are setted after contract deploy
var contractAddress = '0x1F9d574bC6DCdbb472EEB1F66C4e441FaD2773c6';
var abi = JSON.parse( `[
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
contract = new web3.eth.Contract(abi, contractAddress);


var abiMatch = JSON.parse( `[ 
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
									"type": 
									"address" 
								} 
							], 
		"name": "ticketHolders", 
		"outputs": 	[ 
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
		"stateMutability": "nonpayable", 
		"type": "function" 
	} 
]` );


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
  contract.methods.getAddresses().call().then( function( adresses ) {
  	console.log("==>",adresses);
  	htmlString = '0';
  	document.getElementById('matchAddress').innerHTML = adresses[0];


    // contractAddressMatch and abiMatch are setted after contract deploy
		var contractAddressMatch = adresses[0];
		//contract instance
		contractMatch = new web3.eth.Contract(abiMatch, contractAddressMatch);

		contractMatch.methods.getMatch().call().then( function( infos ) {
			htmlString = ' '+infos[0]+' vs '+infos[1];
	  	console.log("==>",infos);
	  	document.getElementById('matchAddress').innerHTML = htmlString;

  	});
  });    
}



// signal

contract.events.EventMemo({
    fromBlock: 0
}, function(error, event){ console.log(event); })
.on("connected", function(subscriptionId){
    console.log("subscription",subscriptionId);
})
.on('data', function(event){
    console.log("get data event",event); // same results as the optional callback above
    registerGetMemo();
})
.on('changed', function(event){
    // remove event from local database
    console.log("changed",error, receipt);
})
.on('error', function(error, receipt) { // If the transaction was rejected by the network with a receipt, the second parameter will be the receipt.
	console.log(error, receipt);
});




