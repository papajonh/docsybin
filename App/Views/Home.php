<?php
namespace App\Views;

class home{
    public static function index(){

        $content = 
<<<HTML
        <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deashboard</title>
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="container-menu"></div>
            <div class="container-logo"></div>
            <div class="container-path"></div>
            <div class="container-painel"></div>
        </div>
        <div class="container-nav">
            <nav>
                <div>
                    <label for="new">Novo</label>
                </div>
                <div>
                    <label for="comment">Comentar</label>
                </div>
                <div>
                    <label for="rename">Renomear</label>
                </div>
                <div>
                    <label for="update">Atualizar</label>
                </div>
                <div>
                    <label for="download">Baixar</label>
                </div>
                <div>
                    <label for="delete">Deletar</label>
                </div>
            </nav>
        </div>
    </header>
    <main>
            <div class="container-lib">
                <div class="container-lib-header">
                    <h1>Biblioteca</h1>
                </div>
                <div class="container-lib-body">
                    <label>teste 123</label>
                    <label>teste 123</label>
                    <label>teste 123</label>
                </div>
            </div>
            <div class="container-body">
                <div class="container-body-main">
                    <div class="container-body-header">
                        <label>Versao</label>
                        <label>1 Versões</label>
                        <label>teste 123</label>
                    </div>
                    <div class="container-body-content">
                        <div class="content"></div>
                    </div>
                </div>
                
            </div>
        
    </main>
    
</body>
</html>

HTML;

    return $content;    

    }
}