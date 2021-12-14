/******************************************************Connexion à la bdd******************************************************/
const { Sequelize } = require("sequelize");
const sequelize = new Sequelize("mysql://root:root@localhost:3306/eComerce");

try 
{
    sequelize.authenticate();
    console.log ("connexion etablie");
} 
catch(error)
{
    console.error("erreur de connexion : ", error);
}
/******************************************************************************************************************************/

module.exports = sequelize;