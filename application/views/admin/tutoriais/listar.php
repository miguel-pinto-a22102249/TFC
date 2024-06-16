<div id="Area-Lista-Tutoriais" class="area-listagem">
    <div class="row">
        <div class="columns large-12">
            <?php foreach ($tutoriais as $tutorial_group) { ?>
                <ul class="large-block-grid-2">
                    <? foreach ($tutorial_group as $tutorial) {
                        $title = isset($cache[$tutorial]) ? $cache[$tutorial] : 'Unknown title';
                        str_replace('FomeZer0 - ', '', $title);
                        echo "<li>
            <iframe style='max-width: 100%' width='100%' height='315' src='https://www.youtube.com/embed/$tutorial?si=LwGnWypORRXK1ljI' title='$title' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>
            <p>$title</p>
        </li>";
                    } ?>
                </ul>
            <? } ?>
        </div>
    </div>
</div>
