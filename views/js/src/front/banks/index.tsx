/**
 * Copyright (c) 2012-2019, Mollie B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
 * DAMAGE.
 *
 * @author     Mollie B.V. <info@mollie.nl>
 * @copyright  Mollie B.V.
 * @license    Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @category   Mollie
 * @package    Mollie
 * @link       https://www.mollie.nl
 */
import React from 'react';
import { render, unmountComponentAtNode } from 'react-dom';
import xss from 'xss';

import Banks from '@banks/components/Banks';
import { IBanks, ITranslations } from '@shared/globals';

declare let window: any;

export default function (banks: IBanks, translations: ITranslations): void {
  let issuer = Object.values(banks)[0].id;
  function _setIssuer(newIssuer: string): void {
    issuer = newIssuer;
  }

  const wrapper = document.createElement('DIV');
  render(<Banks banks={banks} translations={translations} setIssuer={_setIssuer}/>, wrapper);
  const elem = wrapper.firstChild as Element;

  import(/* webpackChunkName: "sweetalert", webpackPrefetch: true */ 'sweetalert').then(({ default: swal }) => {
    swal({
      title: xss(translations.chooseYourBank),
      content: {
        element: elem,
      },
      buttons: {
        cancel: {
          text: xss(translations.cancel),
          visible: true,
        },
        confirm: {
          text: xss(translations.choose),
        },
      },
    }).then((value: any) => {
      if (value) {
        const win = window.open(banks[issuer].href, '_self');
        win.opener = null;
      } else {
        try {
          setTimeout(() => unmountComponentAtNode(wrapper), 2000);
        } catch (e) {
        }
      }
    });
  });
}

