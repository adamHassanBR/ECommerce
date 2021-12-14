/**************PERMET DE DIRE À SEQUELIZE QUEL SONT LES ATTRIBUE DE LA TABLE PRODUCT**************/

//permet d'importer Sequelize et de créer un Model
const { Sequelize, DataTypes, Model } = require("sequelize");

const sequelize = new Sequelize("mysql://root:root@localhost:3306/eComerce");

//créer une classe qui érite de model
class product extends Model {}

//initialisation de la class product
product.init
(
    {
        //Uniquement si l'id en bdd =! 'id'
        id_product:
        {
            type:DataTypes.INTEGER,
            primaryKey: true
        },

        //initialisation de l'atribue id_cat dans la table product
        id_cat:
        {
            type: DataTypes.INTEGER,
            allowNull: false
        },

        //initialisation de l'atribue id_marque dans la table product
        id_marque:
        {
            type: DataTypes.INTEGER,
            allowNull: false
        },

        //initialisation de l'atribue des_prod dans la table product
        des_prod:
        {
            type: DataTypes.STRING,
            allowNull: false
        },
       
        //initialisation de l'atribue price dans la table product
        price:
        {
            type: DataTypes.FLOAT,
            allowNull: false
        },

        //initialisation de l'atribue price dans la table product
        picture:
        {
            type: DataTypes.TEXT,
            allowNull: false
        }

        
    },
    {
        //initialisation des parametre de la classe product
        sequelize, // equivalent au PDO en PHP, modul qui permet de faire les connexion en BDD
        timestamps: true, //accepte les parametre de type date
        underscored: true, //permlet d'accepter les underscor(_) qui definise les nom dans la table
        tableName: "product", // indication du nom de la table en BDD
        modelName: "product" //nom qu'on vas utiliser pour appeler la class
    }
)

//export du model
module.exports = product;

/**************PERMET DE DIRE À SEQUELIZE QUEL SONT LES ATTRIBUE DE LA TABLE PRODUCT**************/