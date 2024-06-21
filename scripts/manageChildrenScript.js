function confirmDelete(_name, _id) {    
    if (confirm("Are you sure you want to remove " + _name + " from your children?")) {
        location.href='../controller/deleteChildController.php?ID=' +  _id;
    }
}