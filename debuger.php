<?php

require_once 'RadaParser.php';
 
$parser = RadaParser::getInstance();
$items = $parser->parsingAll(5);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rada Parsing Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

    <div>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#vote_events" aria-controls="vote_events" role="tab" data-toggle="tab">vote_events</a></li>
        <li role="presentation"><a href="#votes" aria-controls="votes" role="tab" data-toggle="tab">votes</a></li>
        <li role="presentation"><a href="#bills" aria-controls="bills" role="tab" data-toggle="tab">bills</a></li>
      </ul>
    
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="vote_events">
            <table class="table">
                <thead>
                    <tr>
                        <th>identifier</th>
                        <th>title</th>
                        <th>start_date</th>
                        <th>result</th>
                        <th>source_url</th>
                        <th>debate_url</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items['vote_events'] as $item): ?>
                    <tr>
                        <td><?= $item['vote_event_id'] ?></td>
                        <td><?= $item['title'] ?></td>
                        <td><?= $item['date'] ?></td>
                        <td><a target="_blank" href="<?= $item['debate_url'] ?>" data-toggle="tooltip" data-placement="left" title="<?= $item['debate_url'] ?>">Перейти</a></td>
                        <td><a target="_blank" href="<?= $item['sourse_url'] ?>" data-toggle="tooltip" data-placement="left" title="<?= $item['sourse_url'] ?>">Перейти</a></td>
                        <td><?= $item['result'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="votes">
            <table class="table">
                <thead>
                    <tr>
                        <th>vote_event_id</th>
                        <th>voter_name</th>
                        <th>option</th>
                        <th>group_name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items['votes'] as $item): ?>
                    <tr>
                        <td><?= $item['vote_event_id'] ?></td>
                        <td><?= $item['voter'] ?></td>
                        <td><?= $item['option'] ?></td>
                        <td><?= $item['group_id'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>    
        </div>
        <div role="tabpanel" class="tab-pane" id="bills">
            <table class="table">
                <thead>
                    <tr>
                        <th>official_id</th>
                        <th>title</th>
                        <th>url</th>
                        <th>vote_event_id</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items['bills'] as $item): ?>
                    <tr>
                        <td><?= $item['official_id'] ?></td>
                        <td><?= $item['title'] ?></td>
                        <td><a target="_blank" href="<?= $item['url'] ?>" data-toggle="tooltip" data-placement="left" title="<?= $item['url'] ?>">Перейти</a></td>
                        <td><?= $item['vote_event_id'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>   
        </div>
      </div>

    </div>
    
    
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
</script>
</body>
</html>