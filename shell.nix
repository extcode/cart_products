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
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/cgl.sh"
    '';
  };

  projectCglFix = pkgs.writeShellApplication {
    name = "project-cgl-fix";

    runtimeInputs = [
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/cgl.sh" --fix
    '';
  };

  projectLint = pkgs.writeShellApplication {
    name = "project-lint";

    runtimeInputs = [
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

  projectPhpstan = pkgs.writeShellApplication {
    name = "project-phpstan";

    runtimeInputs = [
      php
    ];

    text = ''
      "$PROJECT_ROOT/Build/Scripts/phpstan.sh"
    '';
  };

  projectTestUnit = pkgs.writeShellApplication {
    name = "project-test-unit";
    runtimeInputs = [
      php
      projectInstall
    ];
    text = ''
      project-install
      "$PROJECT_ROOT/Build/Scripts/phpunit.sh" unit
    '';
  };

  projectTestFunctional = pkgs.writeShellApplication {
    name = "project-test-functional";
    runtimeInputs = [
      php
      projectInstall
    ];
    text = ''
      project-install
      "$PROJECT_ROOT/Build/Scripts/phpunit.sh" functional
    '';
  };

  projectTestWithCoverage = pkgs.writeShellApplication {
    name = "project-test-with-coverage";
    runtimeInputs = [
      php
      projectInstall
    ];
    text = ''
      project-install
      XDEBUG_MODE=coverage ./.Build/bin/phpunit -c Build/phpunit.xml.dist --coverage-html=coverage_result
    '';
  };

  projectTestAcceptance = pkgs.writeShellApplication {
    name = "project-test-acceptance";
    runtimeInputs = [
      projectInstall
      pkgs.sqlite
      pkgs.firefox
      pkgs.geckodriver
      pkgs.procps
      php
    ];
    text = ''
      project-install
      "$PROJECT_ROOT/Build/Scripts/acceptance.sh" "$@"
    '';
  };

in pkgs.mkShellNoCC {
  name = "TYPO3 Extension extcode/cart-products";
  buildInputs = [
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
