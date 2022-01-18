// SPDX-License-Identifier: GPL-3.0
pragma solidity >=0.7.0 <0.9.10;

contract ListAddress {

    event NewAddress(uint taille, address address_billet);

    address[] private addresses;

    function addAddress(address address_billet) public {
        addresses.push(address_billet);
        emit NewAddress(addresses.length, address_billet);
    }

    // function that returns entire adresses
    function getAddresses() public view returns (address[] memory) {
        return addresses;
    }
}