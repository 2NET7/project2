import { View, Text, Image, TouchableOpacity, StyleSheet, FlatList, StatusBar, ScrollView, ActivityIndicator } from 'react-native';
import React from 'react';
import { AntDesign } from '@expo/vector-icons';
import { useRouter } from 'expo-router';
import { useSafeAreaInsets } from 'react-native-safe-area-context'; // Import useSafeAreaInsets


import { useEffect, useState } from 'react';
import { API_URL } from '../api/config';

const EdukasiBencana: React.FC = () => {
  const router = useRouter();
  const insets = useSafeAreaInsets();
  const [disasters, setDisasters] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`${API_URL}/jenis-bencana`)
      .then(res => res.json())
      .then(json => {
        setDisasters(Array.isArray(json.data) ? json.data : []);
        setLoading(false);
      })
      .catch(() => setLoading(false));
  }, []);

  const handlePress = (name: string) => {
    router.push({ pathname: '/(tabs)/ListEdukasiByJenis', params: { jenis: name } });
  };

  const renderDisasterItem = ({ item }: { item: any }) => (
    <TouchableOpacity
      key={item.id}
      style={styles.gridItem}
      onPress={() => handlePress(item.nama_jenis)}>
      {/* Gambar bisa diambil dari item.image_url jika ada di API */}
      <Image source={require('@/assets/images/Banjir.png')} style={styles.itemImage} />
      <Text style={styles.itemText}>{item.nama_jenis}</Text>
    </TouchableOpacity>
  );

  if (loading) {
    return <View style={styles.container}><ActivityIndicator size="large" color="#D48442" style={{marginTop: 40}} /></View>;
  }
  return (
    <View style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor="#D48442" />
      <View style={[styles.header, { paddingTop: insets.top + 10 }]}> 
        <TouchableOpacity style={styles.backButton} onPress={() => router.push('/Homepage')}>
          <AntDesign name="arrowleft" size={24} color="white" />
        </TouchableOpacity>
        <Text style={styles.headerText}>Edukasi Bencana</Text>
        <View style={{ width: 24 }} />
      </View>
      <FlatList
        data={disasters}
        renderItem={renderDisasterItem}
        keyExtractor={(item) => item.id.toString()}
        numColumns={2}
        contentContainerStyle={styles.gridContainer}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#FFF8F0', // Warna latar belakang keseluruhan
  },
  header: {
    width: '100%',
    backgroundColor: '#D48442',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between', // Menyebar elemen secara horizontal
    paddingHorizontal: 16,
    paddingBottom: 16, // Padding bawah untuk header
    borderBottomLeftRadius: 20,
    borderBottomRightRadius: 20,
    shadowColor: '#000', 
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 5,
    elevation: 8,
  },
  backButton: {
    // Ukuran ikon sudah di AntDesign, tidak perlu fontSize di sini
    // Jika perlu margin kanan: marginRight: 8,
    // Kita biarkan header mengatur posisinya
  },
  headerText: {
    flex: 1, // Mengambil sisa ruang
    textAlign: 'center', // Pusatkan teks di ruang flex-nya
    color: 'white',
    fontWeight: 'bold',
    fontSize: 20, // Ukuran font sedikit lebih besar
  },
  gridContainer: {
    padding: 16,
    paddingTop: 20, // Sedikit ruang di atas grid
  },
  gridItem: {
    flex: 1, // Agar item memenuhi ruang yang tersedia dalam kolom
    backgroundColor: 'white',
    borderRadius: 15,
    padding: 15,
    alignItems: 'center',
    justifyContent: 'center',
    margin: 8, // Margin antar item
    shadowColor: '#000', // Shadow untuk efek card
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 3.84,
    elevation: 5,
    minHeight: 150, // Tinggi minimal untuk item agar konsisten
  },
  itemImage: {
    width: 70, // Ukuran ikon sedikit lebih besar
    height: 70,
    resizeMode: 'contain',
    marginBottom: 10, // Margin bawah untuk teks
  },
  itemText: {
    fontSize: 15, // Ukuran font sedikit lebih besar
    textAlign: 'center',
    color: '#333', // Warna teks lebih gelap
    fontWeight: 'bold',
  }
});

export default EdukasiBencana;