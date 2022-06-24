<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\DTO;

use App\DTO\Response\EarningsCalendarDTO;
use Illuminate\Contracts\Validation\Validator;

/**
 * @property float $transaction_price
 * @property string $transaction_code
 * @property string $transaction_date
 * @property string $filling_date
 * @property int $change
 * @property int $share
 */
class TransactionDTO extends AbstractModelDTO
{

    public function rules(): array
    {
        return [
            'share' => ['numeric', 'required'],
            'change' => ['numeric', 'required'], //FIXME а если -515?
            'filling_date' => ['date_format:"Y-m-d"', 'required'],
            'transaction_date' => ['date_format:"Y-m-d"', 'required'],
            'transaction_code' => ['string', 'required'],
            'transaction_price' => ['numeric', 'required'],
        ];
    }

    public function fromInsiderTransactions(EarningsCalendarDTO $data): Validator
    {
        $this->share = $data->share;
        $this->change = $data->change;
        $this->filling_date = $data->filingDate;
        $this->transaction_date = $data->transactionDate;
        $this->transaction_code = $data->transactionCode;
        $this->transaction_price = $data->transactionPrice;

        return parent::validator($this);
    }
}
