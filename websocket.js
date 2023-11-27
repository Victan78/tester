const app = require("express")();
const http = require("http").createServer(app);

const io = require("socket.io")(http, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"],
  },
});
var liste = [
  "est tomber sur ce salon",
  "a rejoint le salon",
  "a atterit dans le salon",
  "sauvage apparait dans le salon",
];
function hazard(liste) {
  return liste[Math.floor(Math.random() * liste.length)];
}
io.on("connection", (socket) => {
  console.log("a user connected");
  socket.on("join", (data) => {
    console.log(`${data.username} a rejoint le salon ${data.room}`);
    socket.join(data.room);
    socket.broadcast
      .to(data.room)
      .emit("message", {
        username: `${data.username}`,
        message: ` ${hazard(liste)} ${data.room}`,
      });
  });

  socket.on("disconnect", (data) => {
    console.log(`${data.username} a quitté le salon ${data.room}`);
  });
  // Recevoir un message via la connexion socket.io
  // Recevoir un message via la connexion socket.io
  socket.on("message", (data) => {
    console.log(
      `Message reçu de ${data.username}: ${data.message} dans le salon ${data.room}`
    );
    io.to(data.room).emit("message", data);
  });

  socket.on("madou", (olo) => {
    console.log(olo);
    io.to(olo.room).emit("message", {
      username: olo.username,
      content: olo.content,
    });
  });
  socket.on("disconnect", () => {
    console.log("user disconnected");
  });
});

const port = 4000;
http.listen(port, () => {
  console.log(`Server running on port ${port}`);
});

