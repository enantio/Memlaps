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