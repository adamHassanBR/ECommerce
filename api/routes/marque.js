/**************PERMET DE DEFINIR LA ROUTE**************/

let express = require("express");
let router = express.Router();

const marqueModel = require("../models/marque");
const productModel = require("../models/product");

router.get("/", async(req, res) =>
    {
        let marqueAffiche = await marqueModel.findAll();
        console.log(marqueAffiche);

        //création json a reset
        res.status(200).json(marqueAffiche);
    }
)

router.get("/:idmarque/products", async (req,res)=>
    {
        let { idmarque } = req.params;
        let product = await productModel.findAll
        (
            {
                where:
                {
                    id_marque: idmarque
                },
            }
        ) 
        res.status(200).json(product);
    }
)

router.get("/:idmarque/name", async (req,res)=>
    {
        let { idmarque } = req.params;

        let lamarque = await marqueModel.findByPk(idmarque);
       
        res.status(200).json(lamarque.nom_marque);
    }
)

module.exports = router;

/**************PERMET DE DEFINIR LA ROUTE**************/