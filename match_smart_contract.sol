// SPDX-License-Identifier: GPL-3.0
pragma solidity >=0.7.0 <0.9.10;

contract Ticket {
    
    string homeTeam;
    string guestTeam;
    string matchDate;
    uint256 ticketPrice;
    uint256 numberOfTickets;
    address owner;
    mapping (address => uint256) public ticketHolders;

    constructor(string memory _homeTeam, string memory _guestTeam, string memory _matchDate, uint256 _numberOfTickets, uint256 _ticketPrice) {
        homeTeam = _homeTeam; 
        guestTeam = _guestTeam; 
        matchDate = _matchDate;
        numberOfTickets = _numberOfTickets;
        ticketPrice = _ticketPrice;
        owner = msg.sender;
    }

    function buyTicket(address _user, uint256 _amount) public payable {
        require(numberOfTickets >= _amount);
        require(msg.value == ticketPrice * _amount);
        addTickets(_user, _amount);
        numberOfTickets = numberOfTickets - _amount;
    }

    function useTickets(address _user, uint256 _amount) public {
        subTickets(_user, _amount);
    }

    function addTickets(address _user, uint256 _amount) internal {
        ticketHolders[_user] = ticketHolders[_user] + _amount;
    }

    function subTickets(address _user, uint256 _amount) internal {
        require(ticketHolders[_user] >= _amount, "You do not have anough tickets.");
        ticketHolders[_user] = ticketHolders[_user] - _amount;
    }

    function withdraw() public {
        require(msg.sender == owner, "You are not the owner.");
        (bool success, ) = payable(owner).call{value: address(this).balance}("");
        require(success);
    }

    function getMatch() public view returns(string memory, string memory, string memory, uint256, uint256){
        return (homeTeam, guestTeam, matchDate, numberOfTickets, ticketPrice);
   }

}