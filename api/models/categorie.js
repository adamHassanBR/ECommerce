/**************PERMET DE DIRE À SEQUELIZE QUEL SONT LES ATTRIBUE DE LA TABLE CATEGORIE**************/

//permet d'importer Sequelize et de créer un Model
const { Sequelize, DataTypes, Model } = require("sequelize");

const sequelize = new Sequelize("mysql://root:root@localhost:3306/eComerce");

//créer une classe qui érite de model
class categorie extends Model {}

//initialisation de la class categorie
categorie.init
(
    {
        //initialisation de l'atribue des_cat dans la table categorie
        des_cat:
        {
            type: DataTypes.STRING,
            allowNull: false
        },

        //Uniquement si l'id en bdd =! 'id'
        id_cat:
        {
            type:DataTypes.INTEGER,
            primaryKey: true
        }
    },
    {
        //initialisation des parametre de la classe categorie
        sequelize, // equivalent au PDO en PHP, modul qui permet de faire les connexion en BDD
        timestamps: true, //accepte les parametre de type date
        underscored: true, //permlet d'accepter les underscor(_) qui definise les nom dans la table
        tableName: "categorie", // indication du nom de la table en BDD
        modelName: "categorie" //nom qu'on vas utiliser pour appeler la class
    }
)

//export du model
module.exports = categorie;

/**************PERMET DE DIRE À SEQUELIZE QUEL SONT LES ATTRIBUE DE LA TABLE CATEGORIE**************/