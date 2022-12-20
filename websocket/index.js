const httpServer = require('http').createServer();
const io = require('socket.io')(httpServer, {
	cors: {
		// The origin is the same as the Vue app domain. Change if necessary
		origin: '*',
		methods: ['GET', 'POST'],
		credentials: true
	}
});

httpServer.listen(8080, () => {
	console.log('listening on *:8080');
});

io.on('connection', (socket) => {
	console.log(`client ${socket.id} has connected`);

	socket.on('loggedIn', function (user) {
		socket.join(user.id);
		console.log('User ' + user.id + ' has logged in.');
		if (user.type == 'EM') {
			socket.join('administrator')
			console.log('User ' + user.id + ' is an admin.');
		}
	})
	socket.on('loggedOut', function (user) {
		socket.leave(user.id)
		console.log('User ' + user.id + ' has logged out.');
		socket.leave('administrator')
	})
	socket.on('updateUser', function (user) {
		socket.in('administrator').except(user.id).emit('updateUser', user)
		socket.in(user.id).emit('updateUser', user)
	})

	socket.on('ready_dish', () => {
		console.log('A dish has been readied!');
	});

	socket.on('newOrder', (userId) => {
		socket.except(userId).emit('updateOrders');
	});

});