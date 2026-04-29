<script>
	function toggleChecklist(id) {
		const row = document.getElementById('checklist-row-' + id);
		const icon = document.getElementById('icon-' + id);

		if (!row) return;

		const isHidden = row.classList.contains('hidden');

		row.classList.toggle('hidden');

		if (icon) {
			icon.innerText = isHidden ? '▼' : '▶';
		}

		// auto focus input saat dibuka
		if (isHidden) {
			setTimeout(() => {
				const input = document.getElementById('input-' + id);
				if (input) input.focus();
			}, 100);
		}
	}
</script>
