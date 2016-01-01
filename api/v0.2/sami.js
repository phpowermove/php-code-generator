
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">gossi</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">codegen</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:gossi_codegen_config" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="gossi/codegen/config.html">config</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:gossi_codegen_config_CodeFileGeneratorConfig" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/config/CodeFileGeneratorConfig.html">CodeFileGeneratorConfig</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_config_CodeGeneratorConfig" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/config/CodeGeneratorConfig.html">CodeGeneratorConfig</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:gossi_codegen_generator" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="gossi/codegen/generator.html">generator</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:gossi_codegen_generator_CodeFileGenerator" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/generator/CodeFileGenerator.html">CodeFileGenerator</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_generator_CodeGenerator" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/generator/CodeGenerator.html">CodeGenerator</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_generator_DefaultGeneratorStrategy" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/generator/DefaultGeneratorStrategy.html">DefaultGeneratorStrategy</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:gossi_codegen_model" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="gossi/codegen/model.html">model</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:gossi_codegen_model_parts" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="gossi/codegen/model/parts.html">parts</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:gossi_codegen_model_parts_AbstractTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/AbstractTrait.html">AbstractTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_BodyTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/BodyTrait.html">BodyTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_ConstantsTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/ConstantsTrait.html">ConstantsTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_DefaultValueTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/DefaultValueTrait.html">DefaultValueTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_DocblockTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/DocblockTrait.html">DocblockTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_FinalTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/FinalTrait.html">FinalTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_InterfacesTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/InterfacesTrait.html">InterfacesTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_LongDescriptionTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/LongDescriptionTrait.html">LongDescriptionTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_NameTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/NameTrait.html">NameTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_ParametersTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/ParametersTrait.html">ParametersTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_PropertiesTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/PropertiesTrait.html">PropertiesTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_QualifiedNameTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/QualifiedNameTrait.html">QualifiedNameTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_ReferenceReturnTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/ReferenceReturnTrait.html">ReferenceReturnTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_TraitsTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/TraitsTrait.html">TraitsTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_parts_TypeTrait" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="gossi/codegen/model/parts/TypeTrait.html">TypeTrait</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:gossi_codegen_model_AbstractModel" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/AbstractModel.html">AbstractModel</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_AbstractPhpMember" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/AbstractPhpMember.html">AbstractPhpMember</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_AbstractPhpStruct" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/AbstractPhpStruct.html">AbstractPhpStruct</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_ConstantsInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/ConstantsInterface.html">ConstantsInterface</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_DocblockInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/DocblockInterface.html">DocblockInterface</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_GenerateableInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/GenerateableInterface.html">GenerateableInterface</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_NamespaceInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/NamespaceInterface.html">NamespaceInterface</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpClass" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpClass.html">PhpClass</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpConstant" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpConstant.html">PhpConstant</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpFunction" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpFunction.html">PhpFunction</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpInterface.html">PhpInterface</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpMethod" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpMethod.html">PhpMethod</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpParameter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpParameter.html">PhpParameter</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpProperty" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpProperty.html">PhpProperty</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_PhpTrait" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/PhpTrait.html">PhpTrait</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_model_TraitsInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/model/TraitsInterface.html">TraitsInterface</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:gossi_codegen_utils" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="gossi/codegen/utils.html">utils</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:gossi_codegen_utils_GeneratorUtils" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/utils/GeneratorUtils.html">GeneratorUtils</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_utils_ReflectionUtils" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/utils/ReflectionUtils.html">ReflectionUtils</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_utils_Writer" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/utils/Writer.html">Writer</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:gossi_codegen_visitor" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="gossi/codegen/visitor.html">visitor</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:gossi_codegen_visitor_DefaultNavigator" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/visitor/DefaultNavigator.html">DefaultNavigator</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_visitor_DefaultVisitor" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/visitor/DefaultVisitor.html">DefaultVisitor</a>                    </div>                </li>                            <li data-name="class:gossi_codegen_visitor_GeneratorVisitorInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="gossi/codegen/visitor/GeneratorVisitorInterface.html">GeneratorVisitorInterface</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


