<?php

return [
    '/{{\s*(.+?)\s*}}/'       => '<?php echo htmlspecialchars($1); ?>',
    '/@foreach\s*\((.+?)\)/'  => '<?php foreach ($1): ?>',
    '/@endforeach/'           => '<?php endforeach; ?>',
    '/@if\s*\((.+?)\)/'       => '<?php if ($1): ?>',
    '/@elseif\s*\((.+?)\)/'   => '<?php elseif ($1): ?>',
    '/@else/'                 => '<?php else; ?>',
    '/@endif/'                => '<?php endif; ?>',
    '/@dump\s*\((.+?)\)/'     => '<?= $this->dump($1) ?>',
    '/@dd\s*\((.*)\)/'        => '<?= $this->dd($1); ?>',
];