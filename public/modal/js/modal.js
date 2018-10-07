(function() {
  'use strict';

  /**
   * Class name helpers
   */
  function classReg(cl) {
    return new RegExp('(\\s|^)'+ cl +'(\\s|$)');
  }

  function hasClass(el, cl) {
    return el.className.match(classReg(cl));
  }

  function addClass(el, cl) {
    if (!hasClass(el, cl)) {
      el.className += ' ' + cl;
    }
  }

  function removeClass(el, cl) {
    if (hasClass(el, cl)) {
      el.className = el.className.replace(classReg(cl), '');
    }
  }

  /**
   * Extend helper
   */
  function extend(obj1, obj2) {
    var obj = {};
    for (var key in obj1) {
      obj[key] = obj2[key] === undefined ? obj1[key] : obj2[key];
    }
    return obj;
  }

  /**
   * Creates an instance of a modal.
   *
   * @constructor
   * @this {Modal}
   * @param {object} el The container.
   * @param {object} opts Options.
   */
  var Modal = function(el, opts) {

    this.modal = el,
    this.triggerBtn = document.querySelectorAll('[data-trigger-modal="' + this.modal.id + '"]'),
    this.closeBtn = this.modal.querySelectorAll('[data-close-modal]'),
    this.body = document.body,
    this.defaults = {
      activeClass: 'modal--active', // active class set to modal when it opens
      bodyClass: 'modal-is-active', // active class set to body when modal opens
      overlay: true, // adds overlay to modal
      overlayClass: 'modal__overlay', // class for overlay of modal
      openCallback: null, // callback for when modal opens
      closeCallback: null // callack for when modal closes
    },
    opts = opts || {},
    this.opts = extend(this.defaults, opts);

  };
  Modal.prototype  = {

    init: function() {

      // enable triggering of modal
      this.modalTriggering();

    },

    modalTriggering: function() {

      var self = this;

      // add event listeners to all trigger buttons
      for (var i = 0; i < self.triggerBtn.length; i++) {
        self.triggerBtn[i].addEventListener('click', self.openModal.bind(this));
      }

    },

    openModal: function() {

      var self = this;

      // check if overlay is enabled
      if (self.opts.overlay) {
        // append overlay
        self.appendOverlay();
      }

      // add active class to modal
      addClass(self.modal, self.opts.activeClass);

      // add active class to body
      addClass(self.body, self.opts.bodyClass);

      // add event listeners to all close buttons within modal
      for (var i = 0; i < self.closeBtn.length; i++) {
        self.closeBtn[i].addEventListener('click', this.closeModal.bind(this));
      }

      // check for open callback
      if (self.opts.openCallback) {
        self.opts.openCallback.call(self);
      }

      // set focus to first close button within modal
      setTimeout(function() {
        self.closeBtn[0].focus();
      }, 500);

    },

    closeModal: function() {

      var self = this;

      // remove active class from modal
      removeClass(self.modal, self.opts.activeClass);

      // remove active class from body
      removeClass(self.body, self.opts.bodyClass);

      // remove event listeners from all close buttons within modal
      for (var i = 0; i < self.closeBtn.length; i++) {
        self.closeBtn[i].removeEventListener('click', this.closeModal.bind(this));
      }

      // check if overlay is enabled
      if (self.opts.overlay) {
        // remove overlay
        self.removeOverlay();
      }

      // check for close callback
      if (self.opts.closeCallback) {
        self.opts.closeCallback.call(self);
      }

    },

    appendOverlay: function() {

      var self = this;

      // create overlay el
      self.overlay = document.createElement('div');
      self.overlay.className = self.opts.overlayClass;
      self.modal.appendChild(self.overlay);

    },

    removeOverlay: function() {

      var self = this;

      // add delay before removing overlay to allow transition out
      setTimeout(function() {
        self.overlay.remove();
      }, 500);

    }

  };

  window.Modal = Modal;

})();