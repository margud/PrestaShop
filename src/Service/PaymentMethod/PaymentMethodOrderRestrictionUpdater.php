<?php
/**
 * Copyright (c) 2012-2020, Mollie B.V.
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
 *
 * @category   Mollie
 *
 * @see       https://www.mollie.nl
 * @codingStandardsIgnoreStart
 */

namespace Mollie\Service;

use MolliePrefix\Mollie\Api\MollieApiClient;
use MolPaymentMethod;
use MolPaymentMethodOrderTotalRestriction;
use PrestaShopException;

class PaymentMethodOrderRestrictionUpdater
{
	private $apiService;

	public function __construct(ApiService $apiService)
	{
		$this->apiService = $apiService;
	}

	/**
	 * @param MollieApiClient $mollieApiClient
	 * @param MolPaymentMethod $paymentMethod
	 * @param int $currencyId
	 *
	 * @return bool
	 *
	 * @throws PrestaShopException
	 */
	public function update(MollieApiClient $mollieApiClient, MolPaymentMethod $paymentMethod, $currencyId)
	{
		$config = $this->apiService->getPaymentMethodOrderTotalRestriction(
			$mollieApiClient,
			$paymentMethod->id_method,
			\Context::getContext()->currency->iso_code
		);

		if (empty($config)) {
			return true;
		}
		$paymentMethodOrderRestriction = new MolPaymentMethodOrderTotalRestriction();
		$paymentMethodOrderRestriction->currencyId = $currencyId;
		$paymentMethodOrderRestriction->maximumOrderTotal = $config['minimumAmount']['value'];
		$paymentMethodOrderRestriction->minimalOrderTotal = $config['maximumAmount']['value'];
		$paymentMethodOrderRestriction->save();

		return true;
	}
}