<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample</title>
    <link rel="stylesheet" href="sample.css">
</head>

<body>
    <main>
        <?php define('TAB', str_repeat('&nbsp;', 4)); ?>
        <h2>Initiate object</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            require_once('path/to/JsonRequest.php');<br>
            $datas = new JsonRequest('sample_users.json');
        </code>
        <p>
            You can stylize the html table with css file
        </p>

        <code class="code">
            <legend>css</legend>
            .jsonrequest {<br>
            <?php echo TAB ?>border-collapse: collapse;<br>
            <?php echo TAB ?>width: 100%;<br>
            <?php echo TAB ?>font-family: sans-serif;<br>
            }<br>
            .jsonrequest td,<br>
            .jsonrequest th {<br>
            <?php echo TAB ?>border: 1px solid #bbb;<br>
            <?php echo TAB ?>padding: 8px;<br>
            }
        </code>

        <?php
        require_once('../JsonRequest.php');
        $datas = new JsonRequest('sample_users.json');
        ?>
        <h2>Methods</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            getColumns()<br>
            getDatas()<br>
            <br>
            filter()<sup>*</sup><br>
            sort()<sup>*</sup><br>
            reset()<sup>*</sup> <br>
            <br>
            showDatas()<br>
            <br>
            * <em>chainable methods</em>
        </code>
        <h2>Show all</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas->showDatas();
        </code>
        <?php
        echo $datas->showDatas();
        ?>

        <h2>Show all sorted by lastname</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas<br>
            <?php echo TAB ?>->sort('lastname')<br>
            <?php echo TAB ?>->showDatas();
        </code>
        <?php
        echo $datas
            ->sort('lastname')
            ->showDatas();
        ?>

        <h2>Show all sorted by salary DESC</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            $datas<br>
            <?php echo TAB ?>->sort('salary', 'DESC')<br>
            <?php echo TAB ?>->showDatas();
        </code>
        <?php
        echo $datas
            ->sort('salary', 'DESC')
            ->showDatas();
        ?>

        <h2>Show filtered by lastname="durand" and showing columns firstname & salary only</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas<br>
            <?php echo TAB ?>->filter('lastname', 'durand')<br>
            <?php echo TAB ?>->showDatas(array('firstname', 'salary'));
        </code>
        <?php
        echo $datas
            ->filter('lastname', 'durand')
            ->showDatas(array('firstname', 'salary'));
        ?>

        <h2>Show filtered by salary &gt;= 1800</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas<br>
            <?php echo TAB ?>->filter('salary', 1800, '>=')<br>
            <?php echo TAB ?>->showDatas(['firstname','lastname','salary']);
        </code>
        <?php
        echo $datas
            ->filter('salary', 1800, '>=')
            ->showDatas(['firstname', 'lastname', 'salary']);
        ?>

        <h2>Show filtered by birthday &gt; 2000-01-01 </h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas<br>
            <?php echo TAB ?>->filter('birthday', '2000-01-01', '>')<br>
            <?php echo TAB ?>->showDatas();
        </code>
        <?php
        echo $datas
            ->filter('birthday', '2000-01-01', '>')
            ->showDatas();
        ?>

        <h2>Show filtered by lastname containing "dur" and sorted by salary</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            $datas<br>
            <?php echo TAB ?>->filter('lastname','dur', 'LIKE')<br>
            <?php echo TAB ?>->sort('salary', 'DESC')<br>
            <?php echo TAB ?>->showDatas();
        </code>
        <?php
        echo $datas
            ->filter('lastname', 'dur', 'LIKE')
            ->sort('salary', 'DESC')
            ->showDatas();
        ?>

        <h2>Show filtered by salary &gt; 1200 basing on selection "Show filtered by birthday &lt; 2000-01-01"</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas<br>
            <?php echo TAB ?>->filter('birthday', '2000-01-01', '&lt;')<br>
            <?php echo TAB ?>->filter('salary', 1200, '>')<br>
            <?php echo TAB ?>->showDatas();
        </code>
        <?php
        echo $datas
            ->filter('birthday', '2000-01-01', '<')
            ->filter('salary', 1200, '>')
            ->showDatas();
        ?>
        <h2>Show filtered by birthday range between 1993-01-01 and 2000-12-31 sorted by birthday DESC"</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas<br>
            <?php echo TAB ?>->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')<br>
            <?php echo TAB ?>->sort('birthday', 'DESC')<br>
            <?php echo TAB ?>->showDatas();
        </code>
        <?php
        echo $datas
            ->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')
            ->sort('birthday', 'DESC')
            ->showDatas();
        ?>
        <h2>By default, selection is reset after call of showDatas()<br>
            If you want keep the previous selection after displaying it, you can set "reset" to false</h2>
        <hr>
        <code class="code">
            <legend>php</legend>
            echo $datas
            <?php echo TAB ?>->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')<br>
            <?php echo TAB ?>->sort('birthday', 'DESC')<br>
            <?php echo TAB ?>->showDatas(array(),false); // Keep the selection for next call<br>
            <br>
            echo $datas<br>
            <?php echo TAB ?>->filter('salary',1800, '<')<br>
                <?php echo TAB ?>->showDatas();

        </code>
        <?php
        echo $datas
            ->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')
            ->sort('birthday', 'DESC')
            ->showDatas(array(), false);

        echo $datas->filter('salary', 1800, '<')
            ->showDatas();
        ?>

        <code class="code">
            <legend>php</legend>
            // OR
            <br>
            $datas<br>
            <?php echo TAB ?>->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')<br>
            <?php echo TAB ?>->sort('birthday', 'DESC');<br>
            <br>
            $datas<br>
            <?php echo TAB ?>->filter('salary',1800, '<')<br>
                <?php echo TAB ?>->showDatas();
        </code>
        <?php
        $datas
            ->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')
            ->sort('birthday', 'DESC');
        // ->reset(); // you can reset manually after 

        echo $datas
            ->filter('salary', 1800, '<')
            ->showDatas();
        ?>
        <h2>You can also reset manually</h2>
        <hr>
        </h2>
        <code class="code">
            <legend>php</legend>
            $selection = $datas<br>
            <?php echo TAB ?>->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')<br>
            <?php echo TAB ?>->sort('birthday', 'DESC');<br>
            <br>
            // new selection<br>
            echo datas<br>
            <?php echo TAB ?>->reset()<br>
            <?php echo TAB ?>->filter('salary',1800, '<')<br>
                <?php echo TAB ?>->showDatas();
        </code>
        <?php
        $selection = $datas
            ->filter('birthday', ['1993-01-01', '2000-12-31'], 'BETWEEN')
            ->sort('birthday', 'DESC');

        echo $datas
            ->reset()
            ->filter('salary', 1800, '<')
            ->showDatas();
        ?>
        <h2>Use your own loop</h2>
        <hr>
        </h2>
        <code class="code">
            <legend>php</legend>
            $datas->filter('firstname','ma','LIKE');<br>
            foreach ($datas->getDatas() as $obj) {<br>
            <?php echo TAB ?>echo $obj->lastname . ' ' . $obj->firstname . '&lt;br&gt;';<br>
            }<br>
            $datas->reset();
        </code>
        <p>
            <?php
            $datas->filter('firstname', 'ma', 'LIKE');
            foreach ($datas->getDatas() as $obj) {
                echo $obj->lastname . ' ' . $obj->firstname . '<br>';
            }
            $datas->reset();
            ?>
        </p>

        <h2>Use your own JSON source</h2>
        <hr>
        </h2>
        <code class="code">
            <legend>php</legend>
            $source =json_decode(file_get_contents('sample_users2.json'));<br>
            $datas = new JsonRequest($source->datas, false);<br>
            echo $datas->showDatas();
        </code>
        <p>
            <?php
            $source =json_decode(file_get_contents('sample_users2.json'));
            $datas = new JsonRequest($source->datas,false);
            echo $datas->showDatas();
            ?>
        </p>
    </main>
</body>

</html>