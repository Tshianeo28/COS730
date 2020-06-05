<?php
session_start();
session_destroy();
header("Location:login");
?>


<div id="toggleAccordion">
    <div class="card">
        <div class="card-header" id="...">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordionOne" aria-expanded="true" aria-controls="defaultAccordionOne">
                    Collapsible Group Item #1 <div class="icons"><svg> ... </svg></div>
                </div>
            </section>
        </div>

        <div id="defaultAccordionOne" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
            <div class="card-body">

                .......................
                .......................

            </div>
        </div>
    </div>

</div>
