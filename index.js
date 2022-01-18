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

// contractAddress and abi are setted after contract deploy
var contractAddress = '0x024540677225E8f53D3E35FDD53428184B7cC947';
var abi = JSON.parse( `[
	{
		"constant": false,
		"inputs": [
			{
				"name": "_memo",
				"type": "string"
			}
		],
		"name": "setMemo",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [],
		"name": "getMemo",
		"outputs": [
			{
				"name": "",
				"type": "string"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"name": "_from",
				"type": "address"
			},
			{
				"indexed": true,
				"name": "memo",
				"type": "string"
			}
		],
		"name": "EventMemo",
		"type": "event"
	}
]` );

//contract instance
contract = new web3.eth.Contract(abi, contractAddress);

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


//Smart contract functions
function registerSetMemo() {
  memo = $("#newMemo").val();
  contract.methods.setMemo (memo).send( {from: account}).then( function(tx) { 
    console.log("Transaction: ", tx); 
  });
  $("#newMemo").val('');
}

function registerGetMemo() {
  contract.methods.getMemo().call().then( function( memo ) { 

    console.log("memo: ", memo);
    document.getElementById('lastMemo').innerHTML = memo;
 //   $("#lastMemo").html(memo);
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




