<pre>
<?php 

    $banco = new mysqli("localhost", "root", "positivo", "phpflix");
    
    // echo var_dump($banco);
    
    // echo print_r($banco);

    // echo "<br>----------------------------------<br>";
    // $busca = $banco->query("SELECT * FROM usuarios");
    // echo print_r($busca);
    
    // echo "<br>----------------------------------<br>";
    // $obj = $busca->fetch_object();
    // echo print_r($obj);
    
    // echo "<br>----------------------------------<br>";
    
    // while($obj = $busca->fetch_object()){
    //     echo print_r($obj);
    // }
    
    // echo "<br>----------------------------------<br>";
    $busca = $banco->query("SELECT id, nome, senha, nickname, email, tipo FROM usuarios");

    $usu = $busca->fetch_object();
    // echo print_r($usu);

    echo "<br> ID: " . $usu->id;
    echo "<br> Nome: " . $usu->nome;
    echo "<br> Usuario: " . $usu->nickname;
    echo "<br> Senha: " . $usu->senha;
    echo "<br> Email: " . $usu->email;
    echo "<br> Tipo: " . $usu->tipo;

?>
</pre>