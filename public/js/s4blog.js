var S4Blog = {};
S4Blog.Common = {
  twoDigits: function(val) {
    return val < 10 ? "0" + val : val;
  }
}
S4Blog.Routes = {
  Media: {
    upload: function() { return Routing.generate("s4blog_media_upload") }
  },
  Article: {
    update: function(id) { return Routing.generate("s4blog_article_update", { id: id }) }
  }
};

S4Blog.Slug = {
  /**
   * Slugifies text
   * @param text
   * @returns {string}
   */
  slugify: function(text) {
    return text.toString().toLowerCase()
      .replace(/\s+/g, '-')
      .replace(/[éèëê]/g, "e")
      .replace(/[iïî]/g, "i")
      .replace(/[àâ]/g, "a")
      .replace(/[oôö]/g, "o")
      .replace(/[^\w\-]+/g, '')
      .replace(/\-\-+/g, '-')
      .replace(/^-+/, '')
      .replace(/-+$/, '');
  }
};
S4Blog.Media = {
  upload: function(file, callback) {
    var formData = new FormData();
    formData.append("file", file);

    $.ajax({
      type: "POST",
      url: S4Blog.Routes.Media.upload(),
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (data) {
        callback({
          path: data.path,
          status: data.status
        });
      },
      error: function(data) {
        callback({
          path: data.path,
          status: data.status
        });
      }
    })
  }
};
S4Blog.Article = {
  Editor: {
    init: function(config) {
      if (tinymce === undefined) {
        throw new Error("Cannot setup the editor : tinymce is not defined.");
      }

      tinymce.init({
        selector: config.selector,
        min_height: 500,
        paste_data_images: true,
        image_advtab: true,
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
        ],
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        language_url: config.languageUrl,
        file_picker_callback: config.pickFile,
        setup: function (editor) {
          editor.on('change', function () {
            tinymce.triggerSave();
          });
        }
      });
    },
  },
  AutoSave: {
    config:{},
    update: function() {
      $.ajax({
        type: "POST",
        url: S4Blog.Routes.Article.update(this.config.id),
        data: this.config.provider(),
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (data) {
          if (typeof this.config.onSave === "function") {
            this.config.onSave();
          }
        }.bind(this),
        error: function(data) {
          console.log("nope", data)
        }
      });
    },
    init: function(config) {
      this.config = config;

      this.update();
      setInterval(function() {
        this.update();
      }.bind(this), config.delay || 30000);
    }
  }
};