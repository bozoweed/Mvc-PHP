
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <div <?php if(!isset($success)) echo "style='display:none;'";?> class="aligntextCenter successMessage">
        <p> <?php  if(isset($success)) echo $success;?> </p>
    </div>
    <h2 class="flexRow space-evenly" style="height:40px">Créer un compt</h2>
    <form class="gridX4 formRegister" style="margin: 0 7%;" method="post">
       
        <div class="gridX4HalfLeft flexColumns space-around  alignItemsCenter">
            <div>
                <label for="name">Nom:</label>
                <br>
                <input type="text" id="name" name="name" required size="26">
            </div>
            <div>
                <label for="email">Email:</label>
                <br>
                <input type="text" id="email" name="email" required size="26">
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <br>
                <input type="password" id="password" name="password" minlength="8" required size="26">
            </div>
        </div>
        <div class="gridX4HalfRight flexColumns space-around  alignItemsCenter">
            <div>
                <label for="lastName">Prénom:</label>
                <br>
                <input type="text" id="lastName" name="lastName" required size="26">
            
            </div>
            <div>
                <label for="phoneNumber">Numéro de portable:</label>
                <br>
                <input type="text" id="phoneNumber" name="phoneNumber" required size="26">
            </div>
            <div>
                <label for="password2">Confirmer le Mot de passe:</label>
                <br>
                <input type="password" id="password2" name="password2" minlength="8" required size="26">
            </div>            
        </div>        
        <div class="gridX4FullRow flexColumns space-around">
            <div class="flexRow space-around " >
                <button style="padding: 6px;" type="submit"  id="submit" name="submit" value="Valider">Valider</button>  
            </div>
              
        </div>  
    </form>    
</div>