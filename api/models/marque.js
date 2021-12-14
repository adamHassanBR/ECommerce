/**************PERMET DE DIRE À SEQUELIZE QUEL SONT LES ATTRIBUE DE LA TABLE marque**************/

//permet d'importer Sequelize et de créer un Model
const { Sequelize, DataTypes, Model } = require("sequelize");

const sequelize = new Sequelize("mysql://root:root@localhost:3306/eComerce");

//créer une classe qui érite de model
class marque extends Model {}

//initialisation de la class marque
marque.init
(
    {
        //Uniquement si l'id en bdd =! 'id'
        id_marque:
        {
            type:DataTypes.INTEGER,
            primaryKey: true
        },

        //initialisation de l'atribue des_cat dans la table marque
        nom_marque:
        {
            type: DataTypes.STRING,
            allowNull: false
        }

        
    },
    {
        //initialisation des parametre de la classe marque
        sequelize, // equivalent au PDO en PHP, modul qui permet de faire les connexion en BDD
        timestamps: false, //accepte les parametre de type date
        underscored: false, //permlet d'accepter les underscor(_) qui definise les nom dans la table
        tableName: "marque", // indication du nom de la table en BDD
        modelName: "marque" //nom qu'on vas utiliser pour appeler la class
    }
)

//export du model
module.exports = marque;

/**************PERMET DE DIRE À SEQUELIZE QUEL SONT LES ATTRIBUE DE LA TABLE marque**************/