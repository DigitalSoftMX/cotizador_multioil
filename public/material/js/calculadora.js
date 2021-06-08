

function Suma() {
   var regularL = document.calculadora.regularL.value;
   var regularMa = document.calculadora.regularMa.value;
   var regularMi = document.calculadora.regularMi.value;
   var regularJ = document.calculadora.regularJ.value;
   var regularV = document.calculadora.regularV.value;
   var regularS = document.calculadora.regularS.value;

   var premiumL = document.calculadora.premiumL.value;
   var premiumMa = document.calculadora.premiumMa.value;
   var premiumMi = document.calculadora.premiumMi.value;
   var premiumJ = document.calculadora.premiumJ.value;
   var premiumV = document.calculadora.premiumV.value;
   var premiumS = document.calculadora.premiumS.value;

   var dieselL = document.calculadora.dieselL.value;
   var dieselMa = document.calculadora.dieselMa.value;
   var dieselMi = document.calculadora.dieselMi.value;
   var dieselJ = document.calculadora.dieselJ.value;
   var dieselV = document.calculadora.dieselV.value;
   var dieselS = document.calculadora.dieselS.value;
  
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
      
      
       document.calculadora.resultado.value = regularL+regularMa+regularMi+regularJ+regularV+regularS;

       document.calculadora.resultado2.value = premiumL+premiumMa+premiumMi+premiumJ+premiumV+premiumS;

       document.calculadora.resultado3.value = dieselL+dieselMa+dieselMi+dieselJ+dieselV+dieselS;
        }
   //Si se produce un error no hacemos nada
   catch(e) {}
}

function SumaP() {
  
   
    try{
       //Calculamos el número escrito:
        
        
       
       
         }
    //Si se produce un error no hacemos nada
    catch(e) {}
 }
