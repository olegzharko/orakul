import React from 'react';

import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomDatePicker from '../../../../../../../../../../../../../../../components/CustomDatePicker';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';
import { RadioButtonsGroup } from '../../../../../../../../../../../../../../../components/RadioButtonsGroup/RadioButtonsGroup';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';

import { usePaymentDelay, Props } from './usePaymentDelay';

const PaymentDelay = (props: Props) => {
  const {
    data,
    setData,
    onSave,
    onClear,
  } = usePaymentDelay(props);

  return (
    <div className="installment">
      <SectionWithTitle title="Відстрочення платежу" onClear={onClear}>
        <div className="grid-center-duet">
          <CustomInput
            type="number"
            label="Номер договору"
            onChange={(e) => setData({ ...data, contractNumber: +e })}
            value={data.contractNumber}
          />
          <CustomDatePicker
            label="Відстрочення до"
            onSelect={(e) => setData({ ...data, paymentDate: e })}
            selectedDate={data.paymentDate}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={false} />
      </div>
    </div>
  );
};

export default PaymentDelay;
