<script setup>
// Placeholder for development purposes
const order = [
	{
		id: 1,
		name: 'My amazing item',
		type: 'Hot dish?',
		description: 'The hottest dish to ever dish.',
		photo_url: 'https://via.placeholder.com/150',
		price: 350000
	}, {
		id: 2,
		name: 'Salad',
		type: 'Hot dish?',
		description: 'The hottest dish to ever dish.',
		photo_url: 'https://via.placeholder.com/150',
		price: 350000
	},
	{
		id: 3,
		name: 'My amazing item',
		type: 'Hot dish?',
		description: 'The hottest dish to ever dish.',
		photo_url: 'https://via.placeholder.com/150',
		price: 350000
	},
	{
		id: 4,
		name: 'My amazing item',
		type: 'Hot dish?',
		description: 'The hottest dish to ever dish.',
		photo_url: 'https://via.placeholder.com/150',
		price: 350000
	}];

const removeItemFromOrder = () => {
	console.log('TODO - Functionality not implemented.');
};
</script>

<template>
	<table class="table">
		<thead>
			<tr>
				<th>Photo</th>
				<th>Name</th>
				<th>Type</th>
				<th>Price</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="item in order" :key="item.id">
				<td>
					<img :src="item.photo_url" />
				</td>
				<td>
					<span>{{ item.name }}</span>
				</td>
				<td>
					<span>
						{{ item.type }}
					</span>
				</td>
				<td>
					<span>
						{{ item.price }}€
					</span>
				</td>
				<td>
					<input type="number" value="1" />
				</td>
				<td>
					<button type="button" class="btn btn-danger" @click="removeItemFromOrder">
						<i class="bi bi-trash"></i>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn-group float-end" role="group">
		<button class="btn btn-danger">
			<router-link class="nav-link" :to="{ name: 'Menu' }">
				Cancel
			</router-link>
		</button>
		<button class="btn btn-success">Complete Order</button>
	</div>
</template>
