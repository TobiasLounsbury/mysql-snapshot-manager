###-begin-mysql-snapshot-completion-###
if complete &>/dev/null; then
  _mysql_snapshot_completion () {
        local words=("${COMP_WORDS[@]}");
        unset words[0];
        unset words[$COMP_CWORD];
        local completions=$("${COMP_WORDS[0]}" autocomplete "${words[@]}");
        COMPREPLY=($(compgen -W "$completions" -- "${COMP_WORDS[$COMP_CWORD]}"));
  }
  complete -F _mysql_snapshot_completion msnap
fi
###-end-mysql-snapshot-completion-###