import React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import { RadioButtonsGroup } from '../../../../../../../../../../../../../../components/RadioButtonsGroup/RadioButtonsGroup';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useInstallment, Props } from './useInstallment';

const Installment = (props: Props) => {
  const {
    installmentRadioButtons,
    data,
    setData,
    onSave,
    onClear,
  } = useInstallment(props);

  return (
    <div className="installment">
      <SectionWithTitle title="Розстрочка" onClear={onClear}>
        <div className="grid">
          <CustomInput
            type="number"
            label="Сума"
            onChange={(e) => setData({ ...data, total_price: +e })}
            value={data.total_price}
          />

          <CustomInput
            type="number"
            label="Кількість місяців"
            onChange={(e) => setData({ ...data, total_month: +e })}
            value={data.total_month}
          />

          <RadioButtonsGroup
            unicId="installmentRadio"
            buttons={installmentRadioButtons}
            selected={data.type}
            onChange={(e) => setData({ ...data, type: e })}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Installment;
