
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class=" aligntextCenter errorMessage">
    <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <form class="gridX4 formLogin" style="margin: 0 7%;"  method="post">
        <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Connexion</h2>
        <div class="gridX4HalfLeft flexColumns space-around  alignItemsCenter">
            <div>
                <label for="email">Email:</label>
                <br>
                <input type="text" id="email" name="email" required size="26">
                
            </div>
        </div>
        <div class="gridX4HalfRight flexColumns space-around  alignItemsCenter">
            <div>
                <label for="password">Password:</label>
                <br>
                <input type="password" id="password" name="password" required size="26">
            </div>
        </div>
        <p class="gridX4FullRow flexRow space-around" style="height:40px"><button style="padding: 6px;" type="submit"  id="submit" name="submit" value="Valider">Connection</button>  </p>
    </form>
</div>