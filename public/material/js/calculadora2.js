

function Suma() {
   var regularL = document.calculadora2.regularL.value;
   var regularMa = document.calculadora2.regularMa.value;
   var regularMi = document.calculadora2.regularMi.value;
   var regularJ = document.calculadora2.regularJ.value;
   var regularV = document.calculadora2.regularV.value;
   var regularS = document.calculadora2.regularS.value;

   var premiumL = document.calculadora2.premiumL.value;
   var premiumMa = document.calculadora2.premiumMa.value;
   var premiumMi = document.calculadora2.premiumMi.value;
   var premiumJ = document.calculadora2.premiumJ.value;
   var premiumV = document.calculadora2.premiumV.value;
   var premiumS = document.calculadora2.premiumS.value;

   var dieselL = document.calculadora2.dieselL.value;
   var dieselMa = document.calculadora2.dieselMa.value;
   var dieselMi = document.calculadora2.dieselMi.value;
   var dieselJ = document.calculadora2.dieselJ.value;
   var dieselV = document.calculadora2.dieselV.value;
   var dieselS = document.calculadora2.dieselS.value;
  
   try{
      //Calculamos el número escrito:
       
       regularL = (isNaN(parseInt(regularL)))? 0 : parseInt(regularL);
       regularMa = (isNaN(parseInt(regularMa)))? 0 : parseInt(regularMa);
       regularMi = (isNaN(parseInt(regularMi)))? 0 : parseInt(regularMi);
       regularJ = (isNaN(parseInt(regularJ)))? 0 : parseInt(regularJ);
       regularV = (isNaN(parseInt(regularV)))? 0 : parseInt(regularV);
       regularS = (isNaN(parseInt(regularS)))? 0 : parseInt(regularS);

       premiumL = (isNaN(parseInt(premiumL)))? 0 : parseInt(premiumL);
        premiumMa = (isNaN(parseInt(premiumMa)))? 0 : parseInt(premiumMa);
        premiumMi = (isNaN(parseInt(premiumMi)))? 0 : parseInt(premiumMi);
        premiumJ = (isNaN(parseInt(premiumJ)))? 0 : parseInt(premiumJ);
        premiumV = (isNaN(parseInt(premiumV)))? 0 : parseInt(premiumV);
        premiumS = (isNaN(parseInt(premiumS)))? 0 : parseInt(premiumS);

        dieselL = (isNaN(parseInt(dieselL)))? 0 : parseInt(dieselL);
        dieselMa = (isNaN(parseInt(dieselMa)))? 0 : parseInt(dieselMa);
        dieselMi = (isNaN(parseInt(dieselMi)))? 0 : parseInt(dieselMi);
        dieselJ = (isNaN(parseInt(dieselJ)))? 0 : parseInt(dieselJ);
        dieselV = (isNaN(parseInt(dieselV)))? 0 : parseInt(dieselV);
        dieselS = (isNaN(parseInt(dieselS)))? 0 : parseInt(dieselS);
      
      
       document.calculadora2.resultado.value = regularL+regularMa+regularMi+regularJ+regularV+regularS;

       document.calculadora2.resultado2.value = premiumL+premiumMa+premiumMi+premiumJ+premiumV+premiumS;

       document.calculadora2.resultado3.value = dieselL+dieselMa+dieselMi+dieselJ+dieselV+dieselS;

       document.calculadora2.resultado4.value = regularL+regularMa+regularMi+regularJ+regularV+regularS+premiumL+premiumMa+premiumMi+premiumJ+premiumV+premiumS+dieselL+dieselMa+dieselMi+dieselJ+dieselV+dieselS;
        }
   //Si se produce un error no hacemos nada
   catch(e) {}
}

