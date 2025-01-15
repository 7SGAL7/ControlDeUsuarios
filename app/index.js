import express from "express"

import path from 'path';
import {fileURLToPath} from 'url';
const __dirname = path.dirname(fileURLToPath(import.meta.url));

const app = express()
app.set("port", 4000)
app.listen(app.get("port"))


//Configuración
app.use(express.static(__dirname + "/public"));

app.get("/", (rep, res) => res.sendFile(__dirname + "/pages/login.html"))