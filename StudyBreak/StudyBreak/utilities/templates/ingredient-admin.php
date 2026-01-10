<li>
    <input type="checkbox" name="ingredienti[]" id="ingredient-<?php echo $ingrediente->nome ?>"
        value="<?php echo $ingrediente->id ?>">
    <label for="ingredient-<?php echo $ingrediente->nome; ?>">
        <span><img src="../../img/icons/check.svg" alt="" /></span>
        <span><?php echo $ingrediente->nome ?></span>
    </label>
</li>