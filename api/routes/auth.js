/**************PERMET DE DEFINIR LA ROUTE**************/

const bcrypt = require("bcrypt");
let express = require("express");
let router = express.Router();


let userModel = require("../models/user");

//dans le cas ou on crée un utilisateurs
router.post("/register", async(req, res) =>
    {
        try
        {
            const{firstname, lastname, email, password} = req.body;


            //dans le cas ou un champs n'est pas saisie on spot tout
            if(email === "" || typeof email ==="undefined" || firstname === "" || typeof firstname ==="undefined" || lastname === "" || typeof lastname ==="undefined" || password === "" || typeof password ==="undefined")
                {
                    let error = "un ou plusieurs champs obpligatoir n'as pas été rensegnez"
                    console.log(error);
                    return res.status(500).json(error);
                }

            //permet de crypter le mot de passe
            const hash = bcrypt.hashSync(password, 10);

            const user = await userModel.create
            (
                {
                    fName_user: firstname,
                    name_user: lastname,
                    email,
                    password: hash,
                    admin:0
                }
            );
            console.log(user);
            
            return res.status(200).json({"msg" : "ok"})
        }
        catch (error)
        {
            console.log(error);
            return res.status(500).json(error);
        }
    }
)


//dans le cas ou on ce connecte
router.post("/login", async(req, res) =>
    {
        try
        {

            const{email, password} = req.body;
            
            // dans le cas ou l'email opu le mdp est null
            if((email === "")||(password === ""))
            {
                let error = "Les champs obligatoire n'ont pas été rensegnés !";
                console.log(error);
                return res.status(500).json(error);
            }

            //on recupere l'element relatif à l'email en bdd
            const user = await userModel.findOne
            (
                {
                    where:
                    {
                        email: email
                    }
                }
            )

            // dans le cas ou l'email est reconue
            if (user) 
            {
                // dans le cas ou le mdp 
                if(!bcrypt.compareSync(password, user.password))
                {
                    let error = "Erreur lors de l'autantification";
                    console.log(error);
                    return res.status(503).json(error);
                }
                //sinon on valide cela et on renvoi pas le mdp
                else
                {
                    user.password = null;
                    res.status(200).json(user);
                }
            } 
            // dans le cas ou l'email n'est pas reconue
            else 
            {
                let error = "Erreur lors de l'autantification";
                console.log(error);
                return res.status(503).json(error);
            }
        }
        catch (error)
        {
            console.log(error);
            return res.status(500).json(error);
        }
    }
)

module.exports = router;

/**************PERMET DE DEFINIR LA ROUTE**************/