function toggleForm(action){
	const form = document.getElementById('addForm');
	const filters = document.getElementById('filters');
	if(action == 'open'){
		form.classList.remove('d-none');
		filters.classList.add('d-none');
	} else {
		form.classList.add('d-none');
		filters.classList.remove('d-none');
	}
}