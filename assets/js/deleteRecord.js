/**
 * Handles the confirmation of delete action.
 *
 * @param {Event} event - The event object triggered by the user action.
 * @return {void} No return value.
 */
function confirmDelete(event) {
  event.preventDefault();

  Swal.fire({
    title: "¿Estás seguro de eliminar este registro?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = event.target.href;
    }
  });
}
