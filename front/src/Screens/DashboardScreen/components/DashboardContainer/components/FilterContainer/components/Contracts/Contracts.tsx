import React, { useCallback, useEffect, useState } from 'react';
import './index.scss';

type Props = {
  data: any,
  onChange: (value: string) => void;
}

const Contracts = ({ data, onChange }: Props) => {
  const [selected, setSelected] = useState<string | null>(null);

  const handleChange = useCallback((type: string) => {
    if (selected === type) return;
    setSelected(type);
    onChange(type);
  }, []);

  useEffect(() => {
    setSelected(data ? data[0].type : null);
  }, [data]);

  if (!data) {
    return null;
  }

  return (
    <div className="dashboard__filter-contracts">
      <span className="title">Договори</span>
      <div className="cards">
        {data.map((item: any) => (
          <div
            key={item.key}
            className={`item ${selected === item.type ? 'selected' : ''}`}
            onClick={() => handleChange(item.type)}
          >
            <div className="item__left">
              <img src="/icons/contract.svg" alt="contract" />
              <span className="name">{item.title}</span>
            </div>
            <span className="quantity">{item.count}</span>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Contracts;
