/*
A script that gets runs a function call in a smart contract on Ethereum. This script will probably not work on payable or not constant solidity functions. Use at your own risk. 
*/

const { projectId, privateKey, addrSC } = require('./secrets.json');


console.log(projectId, privateKey, addrSC);

// Add the web3 node module
var Web3 = require('web3');
var web3 = new Web3(new Web3.providers.HttpProvider('https://ropsten.infura.io/v3/'+projectId));


// Convert to account
var account = web3.eth.accounts.privateKeyToAccount(privateKey);

// Set preferance account
web3.eth.accounts.wallet.add(privateKey);
web3.eth.defaultAccount=account.address;

console.log("projectId: ",projectId);
console.log("account: ",account.address);

// Compiler require
var fs=require('fs');
var solc=require('solc');
var ethers=require('ethers');


(async() => {

	// Compile Smartcontract
	console.log("Get smartcontrat (compile: solc -o build --bin cagnotte_cagnotte.sol)");


	var bytecode=fs.readFileSync('build/cagnotte_sol_cagnotte.bin').toString();
	var abi=JSON.parse(fs.readFileSync('build/cagnotte_sol_cagnotte.abi').toString());

	//var gasEstimate=web3.eth.estimateGas({data:contract_byteCode});

	console.log("Send smartcontrat)");
	myContract=new web3.eth.Contract(abi);
	myContract.deploy({
	    data: '0x'+bytecode,
	    arguments: [10,20,50]
	})
	.send({
	    from: account.address,
	    gas: 1500000,
	    gasPrice: '3000000000000'
	})
	.then(function(newContractInstance){
	    console.log("Adress smartcontrat: ",newContractInstance.options.address) // instance with the new contract address
	});

})();



