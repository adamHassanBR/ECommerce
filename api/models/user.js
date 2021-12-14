const { Sequelize, DataTypes, Model } = require("sequelize");
const sequelize = require("../utils/database");

//créer une classe qui érite de model
class user extends Model {}

//initialisation de la class user
user.init
(
    {
        //Uniquement si l'id en bdd =! 'id'
        id_user:
        {
            type:DataTypes.INTEGER,
            primaryKey: true
        },

        //initialisation de l'atribue name_user dans la table user
        name_user:
        {
            type: DataTypes.STRING,
            allowNull: false
        },
        //initialisation de l'atribue fName_user dans la table user
        fName_user:
        {
            type: DataTypes.STRING,
            allowNull: false
        },
        
        //initialisation de l'atribue email dans la table user
        email:
        {
            type: DataTypes.STRING,
            allowNull: false
        },

        //initialisation de l'atribue password dans la table user
        password:
        {
            type: DataTypes.STRING,
            allowNull: false
        },

        //initialisation de l'atribue admin dans la table user
        admin:
        {
            type: DataTypes.BOOLEAN,
            allowNull: false
        },
    },
    {
        //initialisation des parametre de la classe user
        sequelize, // equivalent au PDO en PHP, modul qui permet de faire les connexion en BDD
        timestamps: true, //accepte les parametre de type date
        underscored: false, //permlet d'accepter les underscor(_) qui definise les nom dans la table
        tableName: "user", // indication du nom de la table en BDD
        modelName: "user" //nom qu'on vas utiliser pour appeler la class
    }
)

module.exports = user;
