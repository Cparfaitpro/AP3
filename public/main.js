function displayDeleteButton(nom, prenom)
{
    document.getElementById("deleteMember").style.display="inline";
    alert("Souhaitez-vous supprimer le Membre" + "\xa0" + nom + "\xa0" + prenom + " de votre équipe ?\n si c'est le cas, nous vous invitons à confirmer en appuyant de nouveau sur le bouton")
    document.getElementById("buttonDelete").style.display="none";
}

function displayUnregisterButton()
{
    document.getElementById("LeaveHackaton").style.display="inline";
    alert("Souhaitez-vous quitter l'Hackhaton actuel, si c'est le cas, veuillez cliquer une seconde fois sur le bouton.")
    document.getElementById("buttonVerifRegister").style.display="none";
}

function deleteUser(id)
{
    fetch('/membre/delete/'+ id)
    .then((data)=>document.getElementById(String(id)).style.display= "none")
}

function modifNomEquipe()
{
    nomEquipe=document.getElementById("nomEquipe").value;
    if (nomEquipe!=="")
    {
        if (nomEquipe.length<20)
        {
            return true;
        }
        else {
            alert("Votre nom d'équipe est trop long (moins de 20 caractères");
            return false;
        }
    }
    else {
        alert("Veuillez remplir le champ.");
        return false;
    }
    
}

function modifMDP()
{
    mdp1=document.getElementById('mdp1').value;
    mdp2=document.getElementById('mdp2').value;
    if( 8 <= mdp1.length && mdp1.length <= 32  )
    {
      if( (/[0-9]/).test(mdp1) ) //Le mdp contient des entiers ?
      {
        if( (/[a-z]/).test(mdp1) ) //Le mdp contient des minuscules ?
        {
            if( (/[A-Z]/).test(mdp1) ) //Le mdp contient des majuscules ?
            {
                if( (/[#?!@$%^&*-]/).test(mdp1)) //Le mdp contient au moins un symbole spécial ?
                {
                    if (mdp1==mdp2) //Le mdp est-il le même que celui confirmer ?
                    {
                        return true;
                    }
                    else {
                        alert("Votre mot de passe n'est pas le même que celui mis en confirmation.");
                        return false;
                    }
                }
                else {
                    alert("Votre mot de passe n'a pas de caractères spéciaux (?,!,#...)");
                    return false;
                }

            }
            else {
                alert("Votre mot de passe n'a pas de majuscule.");
                return false;
            }
            
        }
        else {
            alert("Votre mot de passe n'a pas de miniscule.");
            return false;
        }
        
      }
      else {
        alert("Votre mot de passe n'a pas de caractère numérique.");
        return false;
      }
      
    }
    else {
        alert("Votre mot de passe ne dispose pas de 8 caractères ou dépasse les 32 caractères");
        return false;
    }
    
    
}

function modifLogin()
{
    modifLogin=document.getElementById('modifLogin').value;
    if (modifLogin!=="")
    { 
        if (modifLogin.length<20)
        {
            return true;
        }
        else {
            return false;
        }
        
    }
    else {
        return false;
    }
}