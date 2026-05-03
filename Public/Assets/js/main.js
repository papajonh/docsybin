$(document).ready(function () {
    // Dark mode toggle
    if (localStorage.getItem('darkMode') === 'false') {
        $('body').addClass('light-mode');
    }

    $('.dark-mode-toggle').click(function () {
        $('body').toggleClass('light-mode');
        localStorage.setItem('darkMode', $('body').hasClass('light-mode') ? 'false' : 'true');
    });

    // Busca em tempo real
    let searchTimeout;
    $('#global-search').on('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            let query = $('#global-search').val();
            if (query.length >= 2) {
                $.ajax({
                    url: '/api/search',
                    method: 'GET',
                    data: { q: query },
                    success: function (response) {
                        renderSnippets(response);
                    }
                });
            }
        }, 500);
    });

    // Filtrar snippets
    $('.tab').click(function () {
        let filter = $(this).data('filter');
        $('.tab').removeClass('active');
        $(this).addClass('active');

        $.ajax({
            url: '/api/snippets',
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                renderSnippets(response);
            }
        });
    });

    // Deletar snippet com confirmação
    $(document).on('click', '.delete-snippet', function () {
        let id = $(this).data('id');
        if (confirm('Tem certeza que deseja excluir este snippet? Esta ação não pode ser desfeita.')) {
            $.ajax({
                url: '/api/snippets/' + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    location.reload();
                },
                error: function () {
                    alert('Erro ao excluir snippet');
                }
            });
        }
    });

    // Duplicar snippet
    $(document).on('click', '.duplicate-snippet', function () {
        let id = $(this).data('id');
        $.ajax({
            url: '/api/snippets/' + id + '/duplicate',
            method: 'POST',
            success: function (response) {
                window.location.href = '/snippet/' + response.id;
            }
        });
    });

    // Editor de texto com atalhos
    $('#snippet-content').on('keydown', function (e) {
        // Ctrl+S salvar
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            $('#save-form').submit();
        }
        // Ctrl+B negrito
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            wrapText('**', '**');
        }
        // Ctrl+I itálico
        if (e.ctrlKey && e.key === 'i') {
            e.preventDefault();
            wrapText('*', '*');
        }
    });

    function wrapText(before, after) {
        let textarea = $('#snippet-content')[0];
        let start = textarea.selectionStart;
        let end = textarea.selectionEnd;
        let text = textarea.value;
        let selectedText = text.substring(start, end);
        let replacement = before + selectedText + after;
        textarea.value = text.substring(0, start) + replacement + text.substring(end);
        textarea.selectionStart = start + before.length;
        textarea.selectionEnd = end + before.length;
    }

    // Preview do snippet
    $('#preview-btn').click(function () {
        let content = $('#snippet-content').val();
        $.ajax({
            url: '/api/preview',
            method: 'POST',
            data: { content: content },
            success: function (html) {
                $('#preview-modal').remove();
                $('body').append(`
                    <div id="preview-modal" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.8);z-index:1000;display:flex;align-items:center;justify-content:center;">
                        <div style="background:var(--bg-secondary);max-width:800px;width:90%;max-height:80%;overflow:auto;border-radius:8px;">
                            <div style="padding:16px;border-bottom:1px solid var(--border-color);display:flex;justify-content:space-between;">
                                <h3>Preview</h3>
                                <button onclick="$(this).closest('#preview-modal').remove()" style="background:none;border:none;color:white;font-size:24px;">&times;</button>
                            </div>
                            <div style="padding:24px;">${html}</div>
                        </div>
                    </div>
                `);
            }
        });
    });

    // Exportar snippet
    $('.export-pdf').click(function () {
        let id = $(this).data('id');
        window.open('/api/export/pdf/' + id, '_blank');
    });

    $('.export-json').click(function () {
        let id = $(this).data('id');
        window.open('/api/export/json/' + id, '_blank');
    });

    function renderSnippets(snippets) {
        let html = '';
        snippets.forEach(snippet => {
            html += `
                <div class="snippet-card">
                    <div class="snippet-header">
                        <a href="/snippet/${snippet.id}" class="snippet-title">${escapeHtml(snippet.title)}</a>
                        <span class="snippet-badge badge-${snippet.visibility}">${snippet.visibility}</span>
                    </div>
                    <div class="snippet-description">${escapeHtml(snippet.description || 'Sem descrição')}</div>
                    <div class="snippet-meta">
                        <span>📅 ${new Date(snippet.created_at).toLocaleDateString()}</span>
                        <span>📝 ${snippet.word_count || 0} palavras</span>
                        <span>👁️ ${snippet.views || 0} visualizações</span>
                    </div>
                </div>
            `;
        });
        $('.snippet-list').html(html);
    }

    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }
});