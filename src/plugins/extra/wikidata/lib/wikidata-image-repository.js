/* wikidata-image-repository.js is part of Aloha Editor project http://aloha-editor.org
 *
 * Aloha Editor is a WYSIWYG HTML5 inline editing library and editor. 
 * Copyright (c) 2010-2012 Gentics Software GmbH, Vienna, Austria.
 * Contributors http://aloha-editor.org/contribution.php 
 * 
 * Aloha Editor is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or any later version.
 *
 * Aloha Editor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * 
 * As an additional permission to the GNU GPL version 2, you may distribute
 * non-source (e.g., minimized or compacted) forms of the Aloha-Editor
 * source code without the copy of the GNU GPL normally required,
 * provided you include this license notice and a URL through which
 * recipients can access the Corresponding Source.
 */

/* Aloha Editor APA Image Database Repository
 * --------------------------
 * A connector to the APA Image Database
 */

define(
['aloha', 'aloha/jquery'],

function (Aloha, jQuery) {
	'use strict';

	new(Aloha.AbstractRepository.extend({
		_constructor: function () {
			this._super('wikidata-image-repository');
		},

		/**
		 * initalize repository API for APA
		 */
		init: function () {
			this.repositoryUrl = '/aloha-editor/plugins/extra/wikidata/lib/wikidata-image-query.php?q=';
			this.repositoryName = 'wikidata-image-repository'; // can be any other name

			if (Aloha.settings && Aloha.settings.repository && Aloha.settings.repository.wikidata && typeof Aloha.settings.repository.wikidata.url !== 'undefinded') {
				this.repositoryUrl = Aloha.settings.repository.wikidata.url;
			}
		},

		/**
		 * Searches a repository for object items matching query
		 *
		 * @param {Object} p
		 * @param {Function} callback
		 */
		query: function (p, callback) {
			var query = [];

			if (p.queryString && p.queryString.length < 3) {
				// query string needs to be at least 3 chars
				callback.call(this, []);
			} else {
				var that = this;

				jQuery.ajax({
					type: "GET",
					dataType: "json",
					url: this.repositoryUrl + p.queryString,
					success: function (searchResult) {
						var suggestions = [];

						if (searchResult && searchResult.length > 0) {
							for (var i = 0; i < searchResult.length; i++) {
								if (typeof searchResult[i] !== "function") {
									suggestions.push(new Aloha.RepositoryDocument({
										id: searchResult[i].url,
										url: searchResult[i].url,
										name: searchResult[i].title,
										//description: '',
										weight: 0,
										//width: '120',
										//height: '120',
										//width: searchResult[i].hires_width,
										//height: searchResult[i].hires_height,
										repositoryId: that.repositoryName,
										type: "image" // searchResult[i].type
									}));
								}
							}
							callback.call(this, suggestions);
						}
					}
				});
			}
		}
	}))();

});

/*

    [45] => Array
        (
            [preisart] => 0
            [hires_download_allowed] => 1
            [datum] => 2010-06-01
            [bild_id_intern] => 121226-EGRRRGWPOPPAPOGOOEPWAPSAW
            [bild_id] => 20100601_PD2441
            [wz_thumbnail] => 0
            [heikel] => 0
            [hires_size_kb] => 1885
            [model_release] => 
            [hires_width] => 3500
            [wz_hires] => 0
            [inhalt] => epa02183048 REPATING epa02182970 Swiss defender Philippe Senderos,
right, fights for the ball with Costa Rica's defender Gonzalo
Segares, left, during an international friendly test game between
the national soccer teams of Switzerland and Costa Rica at the
Stade de Tourbillon in Sion, Switzerland, June 1, 2010. Ahead of
the FIFA World Cup 2010 in South Africa. Switzerland will play in
group H.  EPA/DOMINIC FAVRE  REAPEATING WITH CORRECTED BYLINE
            [titel] => REPEAT SWITZERLAND SOCCER FIFA WORLD CUP 2010 PREPARATION =
            [lizenzart] => 1
            [credit] => DOMINIC FAVRE / EPA / picturedesk.com
            [stichwort] => SOCCER
            [hires_height] => 2333
            [wz_preview] => 0
            [selection] => archive
            [url] => /aloha-editor/plugins/extra/apa/img/121226-EGRRRGWPOPPAPOGOOEPWAPSAW.png
        )



*/
