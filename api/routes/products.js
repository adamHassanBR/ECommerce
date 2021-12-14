/**************PERMET DE DEFINIR LA ROUTE**************/

let express = require("express");
let router = express.Router();

const product = require("../models/product");

router.get("/", async(req, res) =>
    {
        let productAfficheAll = await product.findAll();
        console.log(productAfficheAll);

        //création json a reset
        res.status(200).json(productAfficheAll);
       
    }
)

router.get("/:productId", async(req, res) =>
    {
        let { productId } = req.params;

        let productAffiche = await product.findByPk(productId);
        console.log(productAffiche);

        //création json a reset
        res.status(200).json(productAffiche);
    
    }
)

module.exports = router;

/**************PERMET DE DEFINIR LA ROUTE**************/