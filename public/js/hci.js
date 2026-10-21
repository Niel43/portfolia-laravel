// HCI: warn users before losing unsaved portfolio edits.
(function () {
  var form = document.getElementById('f');
  if (!form) return;

  var dirty = false;
  function markDirty() { dirty = true; }
  form.addEventListener('input', markDirty);
  form.addEventListener('change', markDirty);
  form.addEventListener('submit', function () { dirty = false; });

  document.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function (event) {
      if (!dirty || event.defaultPrevented || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
      if (link.target === '_blank' || !link.href) return;
      var destination = new URL(link.href, window.location.href);
      if (destination.href === window.location.href) return;
      if (!window.confirm('You have unsaved changes. Do you want to leave this page and discard them?')) {
        event.preventDefault();
      }
    });
  });

  window.addEventListener('beforeunload', function (event) {
    if (!dirty) return;
    event.preventDefault();
    event.returnValue = '';
  });
})();
