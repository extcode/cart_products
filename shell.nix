{
  pkgs ? import <nixpkgs> { }
  ,phpVersion ? "php82"
}:

let
  php = pkgs.${phpVersion}.buildEnv {
    extensions = { enabled, all }: enabled ++ (with all; [
      xdebug
    ]);

    extraConfig = ''
      xdebug.mode = debug
      memory_limit = 4G
    '';
  };
  inherit(pkgs."${phpVersion}Packages") composer;

  projectInstall = pkgs.writeShellApplication {
    name = "project-install";
    runtimeInputs = [
      php
      composer
    ];
    text = ''
      rm -rf .Build/ composer.lock
      composer update --prefer-dist --no-progress --working-dir="$PROJECT_ROOT"
    '';
  };

  projectCgl = pkgs.writeShellApplication {
    name = "project-cgl";

    runtimeInputs = [
      composer
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/cgl.sh"
    '';
  };

  projectCglFix = pkgs.writeShellApplication {
    name = "project-cgl-fix";

    runtimeInputs = [
      composer
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/cgl.sh" --fix
    '';
  };

  projectLintPhp = pkgs.writeShellApplication {
    name = "project-lint-php";

    runtimeInputs = [
      composer
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/lint-php.sh"
    '';
  };

  projectLintTypoScript = pkgs.writeShellApplication {
    name = "project-lint-typoscript";

    runtimeInputs = [
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/lint-typoscript.sh"
    '';
  };

  projectLintXml = pkgs.writeShellApplication {
    name = "project-lint-xml";

    runtimeInputs = [
      pkgs.libxml2
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/lint-xml.sh"
    '';
  };

  projectLintYaml = pkgs.writeShellApplication {
    name = "project-lint-yaml";

    runtimeInputs = [
      pkgs.yamllint
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/lint-yaml.sh"
    '';
  };

  projectLint = pkgs.writeShellApplication {
    name = "project-lint";

    runtimeInputs = [
      projectLintPhp
      projectLintTypoScript
      projectLintXml
      projectLintYaml
    ];

    text = ''
      project-lint-php
      project-lint-typoscript
      project-lint-xml
      project-lint-yaml
    '';
  };

  projectPhpstan = pkgs.writeShellApplication {
    name = "project-phpstan";

    runtimeInputs = [
      composer
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/phpstan.sh"
    '';
  };

  projectTestUnit = pkgs.writeShellApplication {
    name = "project-test-unit";
    runtimeInputs = [
      composer
      php
    ];
    text = ''
      "$PROJECT_ROOT/Build/Scripts/phpunit.sh" unit
    '';
  };

  projectTestFunctional = pkgs.writeShellApplication {
    name = "project-test-functional";
    runtimeInputs = [
      composer
      php
    ];
    text = ''
      "$PROJECT_ROOT/Build/Scripts/phpunit.sh" functional
    '';
  };

  projectTestWithCoverage = pkgs.writeShellApplication {
    name = "project-test-with-coverage";
    runtimeInputs = [
      php
    ];
    text = ''
      XDEBUG_MODE=coverage ./.Build/bin/phpunit -c Build/phpunit.xml.dist --coverage-html=coverage_result
    '';
  };

  projectTestAcceptance = pkgs.writeShellApplication {
    name = "project-test-acceptance";
    runtimeInputs = [
      pkgs.sqlite
      pkgs.firefox
      pkgs.geckodriver
      pkgs.procps
      php
    ];
    text = ''
      "$PROJECT_ROOT/Build/Scripts/acceptance.sh" "$@"
    '';
  };

in pkgs.mkShellNoCC {
  name = "TYPO3 Extension extcode/cart-products";
  buildInputs = [
    pkgs.cacert
    pkgs.firefox
    pkgs.geckodriver
    pkgs.procps
    pkgs.libxml2
    pkgs.yamllint
    php
    composer
    projectInstall
    projectCgl
    projectCglFix
    projectLint
    projectLintPhp
    projectLintTypoScript
    projectLintXml
    projectLintYaml
    projectPhpstan
    projectTestUnit
    projectTestFunctional
    projectTestWithCoverage
    projectTestAcceptance
  ];

  shellHook = ''
    export PROJECT_ROOT="$(pwd)"

    export typo3DatabaseDriver=pdo_sqlite
  '';
}
