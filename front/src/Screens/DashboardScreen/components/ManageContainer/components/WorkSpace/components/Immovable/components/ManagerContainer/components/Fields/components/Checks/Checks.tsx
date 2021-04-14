import * as React from 'react';
import CustomSwitch from '../../../../../../../../../../../../../../components/CustomSwitch';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

export type ManagerChecksData = {
  value: boolean;
  title: string;
  key: string;
}[];

type Props = {
  checksList: ManagerChecksData;
  data: {[key: string]: boolean},
  onChange: (arg: {[key: string]: boolean}) => void,
}

const Checks = ({ data, onChange, checksList }: Props) => {
  const handleClear = () => {
    const newData: {[key: string]: boolean} = {};
    Object.keys(data).forEach((key) => { newData[key] = false; });
    onChange(newData);
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
