function myFunction() {
    if (confirm("Are u sure you want to delete this account?")) {
      location.href = '';
    } else {
      txt = "You pressed Cancel!";
    }
  }