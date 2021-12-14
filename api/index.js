const express = require("express");
const categorie = require("./models/categorie");
const cors = require("cors");
const bodyParser = require("body-parser");


//création des constante pour avoir les bon fichier dans les lien apres
const routesCategorie = require("./routes/categorie");
const routesProducts = require("./routes/products");
const routesMarque = require("./routes/marque");
const routesAuth = require("./routes/auth");

const app = express();
const port = 5001;


//parametre à entrer dans le lien de la page qeb
app.use(cors());
app.use(bodyParser());
app.use(express.static('images'))
app.use("/api/categorie", routesCategorie);
app.use("/api/products", routesProducts);
app.use("/api/marque", routesMarque);
app.use("/api", routesAuth);
app.use("/api/toutcategory", routesAuth)



app.get("/", (req, res) =>
{
    res.status(200).send("Hello World");
});

app.listen(port, () => 
{
    console.log("Server listen on http://localhost:5001");
});