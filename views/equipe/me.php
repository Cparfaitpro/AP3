<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">
    <br></br>
    <br></br>
    <div class="card cardRadius">
        <div class="card-body">

            <h3>Bienvenue « <?= $connected['nomequipe'] ?> »</h3>
            <p>
                <?php if ($hackathon != null && $desinscription) { ?>
                    Votre équipe participera à « <?= $hackathon["thematique"] ?> »
                <?php } else { ?>
                    Vous ne participez à aucun évènement.
                <?php } ?>
            </p>

        </div>

        <div class="card-actions">
            <a href="/logout" class="btn btn-danger btn-small">Déconnexion</a>
        </div>
    </div>
    <br></br>
    <div class="container-fluid overflow-auto">
        <div class="row flex-row flex-nowrap">
            <div class="card cardRadius mt-3 col-3">
                <div class="card-body">
                    <h3>Membres de votre équipe</h3>
                    <div class="panel panel-primary" id="result_panel">
                        <div class="panel-body">
                        <?php if ($membres) { ?>
                            <ul id="ulMembre" class="list-group">
                            <?php 
                                foreach ($membres as $m) { ?>
                                <li class="member" id="<?= $m['idmembre'] ?>">🧑‍💻 <?= "{$m['nom']} {$m['prenom']}  "?><img class="btn btn-danger width" id="buttonDelete" src="../public/img/delete-svgrepo-com.svg" onclick="displayDeleteButton('<?=$m['nom']?>','<?=$m['prenom']?>')"></img>
                                <img id="deleteMember" class="btn btn-success width nonDisplay" src="../public/img/delete-svgrepo-com.svg" onclick=deleteUser(<?= $m['idmembre'] ?>)></img></li>
                            <?php } } else { ?>
                                <p>Vous n'avez aucun membre dans votre équipe, pourquoi ne pas en rajouter ?</p>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>*
            </div>
            <div class="col-1"></div>
            <div class="card cardRadius mt-3 col-3">
                <div class="card-body">
                    <h4>Modification du nom de l'équipe</h4>
                    <form method="POST" onsubmit="return modifNomEquipe();" action='/updateNomEquipe'>
                        <input type="text" id="nomEquipe" name="nomEquipe" placeholder="Nom de l'équipe" value=<?=$connected['nomequipe'] ?>>
                        <button class="btn btn-success" type="submit">Valider</button>
                    </form>
                    <form method="POST" onsubmit="return modifMDP();" action="/updatePassword">
                        <h4>Modification du mot de passe de l'équipe</h4>
                        <p><input type="password" id="mdp1" name="mdp1" placeholder="Entrez votre nouveau mot de passe"></p>
                        <p><input type="password" id="mdp2" name="mdp2" placeholder="Confirmez votre mot de passe"></p>
                        <button class="btn btn-success" type="submit">Valider</button>
                    </form>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="card cardRadius mt-3 col-3">
                <div class="card-body">
                    <h4>Ajouter un membre</h4>
                    <form method="post" action="/membre/add">
                        <div class="row g-1">
                            <div class="col">
                                <input required type="text" placeholder="Nom" name="nom" required="required" class="form-control"/>
                            </div>
                            <div class="col">
                                <input required type="text" placeholder="Prénom" name="prenom" required="required" class="form-control"/>
                            </div>
                            <div class="col">
                                <input required type="text" placeholder="E-mail" name="mail" required="required" class="form-control"/>
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="col">
                                <input required type="text" placeholder="Téléphone" name="telephone" required="required" class="form-control"/>
                            </div>
                            <div class="col">
                                <input required type="date" name="datenaissance" required="required" class="form-control"/>
                            </div>
                            <div class="col">
                                <input required type="text" placeholder="Lien Portfolio" required="required" name="portfolio" class="form-control"/>
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Ajouter" class="btn btn-success d-block" />
                        </div>
                    </form>
                    <form method="POST" onsubmit="modifLogin()"  action='/updateLoginEquipe'>
                        <h4>Modification du login de l'équipe</h4>
                        <input type="text" id="modifLogin" placeholder="Login de l'équipe" name="modifLogin" value=<?=$connected['login'];?>>
                        <button class="btn btn-success" type="submit">Valider</button>
                    </form>
                    <form method="POST" action='/updatePrototype'>
                        <h4>Modification du lien prototype de l'équipe</h4>
                        <input type="url" id="modifPrototype" name="modifPrototype" placeholder="Lien du prototype"  value=<?=$connected['lienprototype'];?>>
                        <button class="btn btn-success" type="submit">Valider</button>
                    </form>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="card cardRadius mt-3 col-3">
                <div class="card-body">
                    <h4>Se désinscrire du Hackaton actuel</h4>
                    <?php if ($hackathon != null && $desinscription) { ?>
                    <form method="POST" action="/membre/leave">
                        <input id="buttonVerifRegister" class="btn btn-danger" type="button" value="Quitter un Hackaton" onclick="displayUnregisterButton()">
                        <button type="submit" class="btn btn-success nonDisplay" id="LeaveHackaton">Confirmation Désinscription</button>
                    </form>
                    <?php } else {?>
                        <p>Vous n'êtes inscrit à aucun Hackathon, inscrivez-vous maintenant ! Ou attendez le prochain ! </p>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
