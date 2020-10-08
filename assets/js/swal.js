let flashdata = $('.flashdata').data('flashdata');

if (flashdata) {
	Swal.fire('Good Job!', 'Success' + flashdata, 'success');
}


$('.btnDelete').on('click', function (e) {
	e.preventDefault();
	let href = $(this).attr('href');

	Swal.fire({
		title: 'Yakin Mau Dihapus ?',
		text: 'Ya atau Tidak!',
		icon: 'warning',
		showCancelButton: true,
		cancelButtonText: 'Tidak!',
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya!'
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	})
});
