/**************PERMET DE DEFINIR LA ROUTE**************/

let express = require("express");
let router = express.Router();

const categorieModel = require("../models/categorie");
const productModel = require("../models/product");

router.get("/", async(req, res) =>
    {
        let categorieAffiche = await categorieModel.findAll();
        //console.log(categorieAffiche);


        //création json a reset
        res.status(200).json(categorieAffiche);
    }
)

router.get("/:idcategorie/products", async (req,res)=>
    {
        let { idcategorie } = req.params;
        let product = await productModel.findAll
        (
            {
                where:
                {
                    id_cat: idcategorie
                },
            }
        ) 
        res.status(200).json(product);
    }
)

router.get("/:idcategorie/name", async (req,res)=>
    {
        let { idcategorie } = req.params;

        let lacat = await categorieModel.findByPk(idcategorie);
       
        res.status(200).json(lacat.des_cat);
    }
)

module.exports = router;

/**************PERMET DE DEFINIR LA ROUTE**************/