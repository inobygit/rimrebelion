<?php
/**
 * Template Name: All Components
 */

inoby_enqueue_parted_style("components", "page_templates");

get_header();
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Colors</h2>
                <div class="colors">
                    <div class="color bg">bg / text</div>
                    <div class="color hdr">header</div>
                    <div class="color foot">footer</div>
                </div>
                <div class="colors">
                    <div class="color prm">primary</div>
                    <div class="color prm light">light</div>
                    <div class="color prm dark">dark</div>
                </div>
                <div class="colors">
                    <div class="color sec">secondary</div>
                    <div class="color sec light">light</div>
                    <div class="color sec dark">dark</div>
                </div>
                <div class="colors">
                    <div class="color danger">danger</div>
                </div>
                <div class="colors">
                    <div class="color success">success</div>
                </div>
                <div class="colors">
                    <div class="color warn">warn</div>
                </div>

                <div class="spacer-sections"></div>
                <h2>Grays</h2>
                <div class="colors">
                    <div class="color g0">white</div>
                    <div class="color g1">100</div>
                    <div class="color g2">200</div>
                    <div class="color g3">300</div>
                    <div class="color g4">400</div>
                    <div class="color g5">500</div>
                    <div class="color g6">600</div>
                    <div class="color g7">700</div>
                    <div class="color g8">800</div>
                    <div class="color g9">900</div>
                    <div class="color g10">black</div>
                </div>

                <div class="spacer-sections"></div>
                <h2>Headings</h2>
                <h1>Heading 1</h1>
                <h2>Heading 2</h2>
                <h3>Heading 3</h3>
                <h4>Heading 4</h4>
                <h5>Heading 5</h5>
                <h6>Heading 6</h6>
                <div class="spacer-sections"></div>
                <hr>
                <div class="spacer-sections"></div>
                <h2>Paragraphs</h2>
                <h3>small</h3>
                <p class="small">Paragraph Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus totam
                    doloremque
                    iste laborum
                    aliquam, repudiandae, ipsam nostrum a nemo dolore corrupti animi. Facilis nostrum vitae provident,
                    praesentium
                    recusandae sint repellat.</p>
                <h3>regular</h3>
                <p>Paragraph Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus totam doloremque iste
                    laborum
                    aliquam, repudiandae, ipsam nostrum a nemo dolore corrupti animi. Facilis nostrum vitae provident,
                    praesentium
                    recusandae sint repellat.</p>
                <h3>large</h3>
                <p class="large">Paragraph Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus totam
                    doloremque
                    iste laborum
                    aliquam, repudiandae, ipsam nostrum a nemo dolore corrupti animi. Facilis nostrum vitae provident,
                    praesentium
                    recusandae sint repellat.</p>
                <div class="spacer-sections"></div>
                <hr>
                <div class="spacer-sections"></div>
                <h2>Unordered Lists (Nested)</h2>
                <ul>
                    <li>List item one
                        <ul>
                            <li>List item one
                                <ul>
                                    <li>List item one</li>
                                    <li>List item two</li>
                                    <li>List item three</li>
                                    <li>List item four</li>
                                </ul>
                            </li>
                            <li>List item two</li>
                            <li>List item three</li>
                            <li>List item four</li>
                        </ul>
                    </li>
                    <li>List item two</li>
                    <li>List item three</li>
                    <li>List item four</li>
                </ul>
                <div class="spacer-sections"></div>
                <hr>
                <div class="spacer-sections"></div>
                <h2>Ordered Lists (Nested)</h2>

                <ol>
                    <li>List item one
                        <ol>
                            <li>List item one
                                <ol>
                                    <li>List item one</li>
                                    <li>List item two</li>
                                    <li>List item three</li>
                                    <li>List item four</li>
                                </ol>
                            </li>
                            <li>List item two</li>
                            <li>List item three</li>
                            <li>List item four</li>
                        </ol>
                    </li>
                    <li>List item two</li>
                    <li>List item three</li>
                    <li>List item four</li>
                </ol>
                <div class="spacer-sections"></div>
                <hr>
                <div class="spacer-sections"></div>
                <h2>Buttons</h2>

                <a class="link" href="#">Link</a>

                <div style="background: white;">
                    <a class="button" href="#">Button</a>
                    <a class="button triangleleft" href="#">Button</a>
                    <a class="button triangleright" href="#">Button</a>
                    <a class="button triangleBoth" href="#">Button</a>
                    <a class="button button-outline" href="#">Button</a>
                </div>
                <div class="spacer-sections"></div>
                <h2>Buttons on dark bg</h2>

                <div style="background: black;">
                    <a class="button light" href="#">Button</a>
                    <a class="button button-outline light" href="#">Button</a>
                </div>
                <div class="spacer-sections"></div>

                <h2>Inputs</h2>
                <div class="group">
                    <input id="chck1" type="checkbox">
                    <label for="chck1">Unchecked checkbox</label>
                </div>
                <div class="group">
                    <input id="chck2" type="checkbox" required checked="checked">
                    <label for="chck2">Checkbox checked</label>
                </div>
                <div class="group">
                    <input id="chck3" type="checkbox" required checked="checked" disabled="disabled">
                    <label for="chck3">Checkbox checked disabled</label>
                </div>
                <div class="group">
                    <input id="chck4" type="checkbox" required disabled="disabled">
                    <label for="chck4">Checkbox unchecked disabled</label>
                </div>

                <div class="">
                    <input type="radio">
                    <label>Check payments</label>
                </div>


                <div class="group">
                    <label for="text1" class="inplace-label">Text</label>
                    <input id="text1" name="text1" type="text" placeholder="Text" />
                </div>
                <div class="group">
                    <label for="number1" class="inplace-label">Number</label>
                    <input id="number1" name="number1" type="number" placeholder="Number" />
                </div>
                <div class="group">
                    <label for="date1" class="inplace-label">Date</label>
                    <input id="date1" name="date1" type="date" placeholder="Date" />
                </div>
                <div class="group">
                    <label for="area1" class="inplace-label">Text area</label>
                    <textarea id="area1" name="area1" placeholder="Text area"></textarea>
                </div>
                <div class="group">
                    <label for="error1" class="inplace-label">Is invalid</label>
                    <input id="error1" name="error1" type="text" placeholder="Is invalid" valud="Invalid value"
                        aria-invalid="true" />
                    <label class="error">This is error message.</label>
                </div>
                <div class="group">
                    <label for="valid1" class="inplace-label">Is valid</label>
                    <input id="valid1" name="valid1" type="text" placeholder="Is valid" value="Valid value"
                        aria-invalid="false" />
                </div>
                <hr>
                <div class="spacer-sections"></div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();