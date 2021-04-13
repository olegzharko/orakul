import * as React from 'react';
import CustomCheckBox from '../../../../../../../../../../../../../../components/CustomCheckBox';
import CustomSwitch from '../../../../../../../../../../../../../../components/CustomSwitch';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

export type ManagerChecksData = {
  right_establishing: boolean,
  technical_passport: boolean,
  rating: boolean,
  fund_evaluation: boolean,
}

type Props = {
  data: ManagerChecksData,
  onChange: (arg: ManagerChecksData) => void,
}

const Checks = ({ data, onChange }: Props) => {
  const handleClear = () => {
    onChange({
      right_establishing: false,
      technical_passport: false,
      rating: false,
      fund_evaluation: false,
    });
  };

  return (
    <SectionWithTitle title="Перевірки" onClear={handleClear}>
      <div className="grid">
        <CustomSwitch
          label="Правовстановлюючий"
          onChange={(e) => onChange({ ...data, right_establishing: e })}
          selected={data.right_establishing}
        />

        <CustomSwitch
          label="Технічний паспорт"
          onChange={(e) => onChange({ ...data, technical_passport: e })}
          selected={data.technical_passport}
        />

        <CustomSwitch
          label="Оцінка"
          onChange={(e) => onChange({ ...data, rating: e })}
          selected={data.rating}
        />

        <CustomSwitch
          label="Оцінка на фонді"
          onChange={(e) => onChange({ ...data, fund_evaluation: e })}
          selected={data.fund_evaluation}
        />
      </div>
    </SectionWithTitle>
  );
};

export default Checks;
