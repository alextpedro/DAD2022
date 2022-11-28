<script setup>
</script>

<template>
	<form class="row g-3 needs-validation" novalidate @submit.prevent="save">
		<div class="form-group">
			<img src="https://via.placeholder.com/150" />
			<input type="file" accept="image/png, image/jpeg" />
		</div>

		<div class="mb-3">
			<label for="inputName" class="form-label">Name</label>
			<input type="text" class="form-control" id="inputName" placeholder="Item Name" required>
			<field-error-message fieldName="name"></field-error-message>
		</div>
	</form>
</template>
