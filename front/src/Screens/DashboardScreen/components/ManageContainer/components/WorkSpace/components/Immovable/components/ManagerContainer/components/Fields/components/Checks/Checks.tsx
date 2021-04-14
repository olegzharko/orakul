import * as React from 'react';
import CustomSwitch from '../../../../../../../../../../../../../../components/CustomSwitch';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

export type ManagerChecksData = {
  value: boolean;
  key: string;
  title: string;
}[];

type Props = {
  checksList: ManagerChecksData;
  data: any,
  onChange: (arg: ManagerChecksData) => void,
}

const Checks = ({ data, onChange, checksList }: Props) => {
  const handleClear = () => {
    onChange(data.reduce((acc: any, item: any) => {
      acc[item.key] = '';
      return acc;
    }, {}));
  };

  return (
    <SectionWithTitle title="Перевірки" onClear={handleClear}>
      <div className="grid">
        {checksList.map((item) => (
          <CustomSwitch
            key={item.key}
            label={item.title}
            onChange={(e) => onChange({ ...data, [item.key]: e, })}
            selected={data ? data[item.key] : false}
          />
        ))}
      </div>
    </SectionWithTitle>
  );
};

export default Checks;
