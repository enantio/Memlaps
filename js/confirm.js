function confirmDelete() {
  if (confirm("Are you sure you want to remove this file?")) {
    document.getElementById("FORM_ID").submit();
  }
  return false;
}

function confirmUnshare() {
  if (confirm("Are you sure you want to Unshare this file?")) {
    document.getElementById("FORM_ID").submit();
  }
  return false;
}

function confirmFriend() {
  if (confirm("Add Friend?")) {
    document.getElementById("FORM_ID").submit();
  }
  return false;
}

function confirmUnfriend() {
  if (confirm("Remove Friend?")) {
    document.getElementById("FORM_ID").submit();
  }
  return false;
}